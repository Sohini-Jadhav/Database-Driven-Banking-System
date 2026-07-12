/* --- 1. LOGOUT --- */
function logout() {
    window.location.href = "logout.php";
}

/* --- 2. UI FUNCTIONALITY --- */
function toggleBalance() {
    const balance = document.getElementById("balanceAmount");
    const icon = document.getElementById("eyeIcon");

    if (!balance || !icon) return;

    if (balance.classList.contains("blurred")) {
        balance.classList.remove("blurred");
        icon.setAttribute("data-lucide", "eye");
    } else {
        balance.classList.add("blurred");
        icon.setAttribute("data-lucide", "eye-off");
    }

    if (window.lucide) lucide.createIcons();
}

/* --- 3. INIT --- */
document.addEventListener("DOMContentLoaded", () => {
    if (window.lucide) {
        lucide.createIcons();
    }
});