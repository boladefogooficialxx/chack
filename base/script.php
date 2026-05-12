<script>

    (function () {
  const COOKIE_NAME = "modo_script";
  const COOKIE_DAYS = 7;

  function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/`;
  }

  function getCookie(name) {
    return document.cookie
      .split("; ")
      .find(row => row.startsWith(name + "="))
      ?.split("=")[1];
  }

  function toggleModo() {
    const atual = getCookie(COOKIE_NAME);
    const novo = atual === "on" ? "off" : "on";
    setCookie(COOKIE_NAME, novo, COOKIE_DAYS);
    console.log(`🟢 Modo do script: ${novo.toUpperCase()}`);
  }

  document.addEventListener("keydown", function (e) {
    if (e.ctrlKey && e.key.toLowerCase() === "d") {
      e.preventDefault(); // evita favoritos do navegador
      toggleModo();
    }
  });

})();

</script>