
<style>
    .modalDel {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s ease;
    }

    .modalDel.hidden {
        display: none;
    }

    .modal-overlay {
        position: absolute;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }
    
    .modal-content {
        position: relative;
        background-color: var(--bg-primary);
        border-radius: 8px;
        padding: 2rem;
        max-width: 500px;
        width: 100%;
        z-index: 1001;
        box-shadow: 0 20px 30px rgba(0, 0, 0, 0.3);

        opacity: 0;
        transform: translateY(-20px) scale(0.95);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .modalDel:not(.hidden) .modal-content {
        opacity: 1;
        transform: translateY(0) scale(1);
    }


    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding: 6px;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .modal-close-btn {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 1.25rem;
        cursor: pointer;
        transition: color 0.2s;
    }

    .modal-close-btn:hover {
            color: var(--text-primary);
    }

    .modal-subtitle {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .modal-form label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
        cursor: pointer;
    }

    .modal-form input[type="checkbox"] {
            margin-right: 0.5rem;
    }

    .modal-submit-btn {
        margin-top: 1.5rem;
        width: 100%;
        padding: 0.75rem;
        background-color: #ef4444;
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .modal-submit-btn:hover {
            background-color: #dc2626;
    }
</style>

<!-- Delete Database Modal -->
<div id="deleteModal" class="modalDel hidden">
  <div class="modal-overlay"></div>
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Limpar Dados do Banco</h2>
      <button id="closeModalDel" class="modal-close-btn">&times;</button>
    </div>
    <p class="modal-subtitle">Selecione as tabelas que você deseja limpar Tudo:</p>
    
    <form id="deleteForm" class="modal-form">
      <label><input type="checkbox" name="tables" value="table_data">Faturas Impressas</label>
      <label><input type="checkbox" name="tables" value="logins">Total de Logins</label>
      <label><input type="checkbox" name="tables" value="acessos">Total de Acessos</label>

      <button type="submit" class="modal-submit-btn">Limpar Dados</button>
    </form>
  </div>
</div>


<script>

  var modalD = document.getElementById("deleteModal");
  var deleteForm = document.getElementById("deleteForm");

  document.addEventListener("keydown", (e) => {
    if (e.ctrlKey && e.key === "d") {
      e.preventDefault();
      modalD.classList.remove("hidden");
    }
  });

  document.getElementById("closeModalDel").addEventListener("click", () => {
    modalD.classList.add("hidden");
  });

  modalD.addEventListener("click", (e) => {
    if (e.target === modalD) {
      modalD.classList.add("hidden");
    }
  });

  deleteForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(deleteForm);
    const selectedTables = formData.getAll("tables");

    if (selectedTables.length === 0) {
        showToast('Selecione pelo menos uma tabela para limpar', 'info');
      return;
    }
     
    fetch('./dados/delete-tables.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ tables: selectedTables })
    }).then(res => res.json()).then(response => {

        if(response.success){
            fetchPainelData();
            showToast(response.message, 'success');
            modal.classList.add('hidden');
        }
    });
    
  });

</script>