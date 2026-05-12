<style>

  /* Botão flutuante */
  .floating-notification-button {
      position: fixed;
      bottom: 45px;
      right: 24px;
      background-color: #1f1f1f;
      color: #FFEB3B;
      border: none;
      border-radius: 50%;
      width: 56px;
      height: 56px;
      padding: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
      cursor: pointer;
      transition: background-color 0.3s ease;
      z-index: 1001;
  }

  .floating-notification-button:hover {
    background-color: #2c2c2c;
  }

  /* Modal base */
  .notification-modal {
    position: fixed;
    bottom: 106px;
    right: 24px;
    width: 320px;
    background-color: #1b1f24;
    border: 1px solid #2a2f36;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.6);
    padding: 0;
    z-index: 1000;
    color: #fff;
    font-family: 'Segoe UI', sans-serif;
  }

  /* Oculto inicialmente */
  .hidden {
    display: none;
  }

  /* Cabeçalho */
  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #333;
    font-weight: bold;
  }
  .modal-header button {
    background: none;
    border: none;
    color: #ccc;
    font-size: 20px;
    cursor: pointer;
  }
  .modal-header button:hover {
    color: #fff;
  }

  /* Lista */
  .notification-list {
    list-style: none;
    margin: 0;
    padding: 0;
    max-height: 300px;
    overflow-y: auto;
  }

  .notification-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #2a2f36;
    font-size: 14px;
    color: #ddd;
  }
  .notification-item:hover {
    background-color: #2a2f36;
  }
  .delete-btn {
    background: none;
    border: none;
    color: #888;
    font-size: 16px;
    cursor: pointer;
  }
  .delete-btn:hover {
    color: #ff5f5f;
  }

</style>

<!-- Botão flutuante -->
<button id="notificationButton" class="floating-notification-button hidden" aria-label="Abrir notificações">
  <svg viewBox="0 0 24 24" fill="currentColor">
    <path d="M12 2C10.34 2 9 3.34 9 5V6.68C6.73 7.58 5 9.99 5 12.75V17L3 19V20H21V19L19 17V12.75C19 9.99 17.27 7.58 15 6.68V5C15 3.34 13.66 2 12 2ZM12 22C13.1 22 14 21.1 14 20H10C10 21.1 10.9 22 12 22Z"/>
  </svg>
</button>

<!-- Modal de notificações -->
<div id="notificationModal" class="notification-modal hidden">
  <div class="modal-header">
    <span>Notificações</span>
    <button id="closeModalNot" aria-label="Fechar">×</button>
  </div>
  <ul id="notificationList" class="notification-list">
  </ul>
</div>

<script>

    var button = document.getElementById("notificationButton");
    var modal = document.getElementById("notificationModal");
    var list = document.getElementById("notificationList");

    // Toggle modal
    button.addEventListener("click", () => {
        modal.classList.toggle("hidden");
    });

    // Fechar modal
    document.getElementById("closeModalNot").addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // Fechar ao clicar fora do modal
    document.addEventListener("click", (e) => {
        if (!modal.contains(e.target) && !button.contains(e.target)) {
          modal.classList.add("hidden");
        }
    });

    // Deletar notificação
    list.addEventListener("click", (e) => {
        if (e.target.classList.contains("delete-btn")) {

           const id = e.target.dataset.id;

           DeletarNot(id);
        }
    });

</script>