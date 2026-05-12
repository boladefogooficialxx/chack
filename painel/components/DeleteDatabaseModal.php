
<style>
  .modalDel {
    position: fixed;
    inset: 0;
    background: rgba(30, 41, 59, 0.7);
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.3s ease;
    font-family: 'Inter', Arial, sans-serif;
  }
  .modalDel.hidden {
    display: none;
  }
  .modal-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(30,41,59,0.8) 60%, rgba(71,85,105,0.7) 100%);
    backdrop-filter: blur(6px);
  }
  .modal-contentD {
       position: relative;
    background: linear-gradient(135deg, #1e293b 80%, #1e293b 100%);
    border-radius: 16px;
    padding: 2.5rem 2rem 2rem 2rem;
    max-width: 420px;
    width: 100%;
    z-index: 1001;
    box-shadow: 0 8px 32px rgba(30, 41, 59, 0.25);
    opacity: 0;
    transform: translateY(-24px) scale(0.96);
    transition: opacity 0.3s, transform 0.3s;
    border: 1px solid #000000;
    color: white;
  }
  .modalDel:not(.hidden) .modal-contentD {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.2rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e2e8f0;
  }
  .modal-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #334155;
    letter-spacing: 0.5px;
  }
  .modal-close-btn {
    background: none;
    border: none;
    color: #dfdfdf;
    font-size: 1.5rem;
    cursor: pointer;
    transition: color 0.2s;
    padding: 0 4px;
  }
  .modal-close-btn:hover {
    color: #ef4444;
    background: #f1f5f9;
    border-radius: 50%;
  }
  .modal-subtitle {
    font-size: 1rem;
    color: #dfdfdf;
    margin-bottom: 1.2rem;
    font-weight: 500;
  }
  .modal-form label {
    display: flex;
    align-items: center;
    margin-bottom: 0.7rem;
    color: #dfdfdf;
    font-size: 0.97rem;
    font-weight: 500;
    cursor: pointer;
    gap: 8px;
  }
  .modal-form input[type="checkbox"] {
    accent-color: #ef4444;
    margin-right: 0.5rem;
    width: 18px;
    height: 18px;
  }
  .modal-form input[type="text"] {
    width: 100%;
    padding: 0.6rem 0.8rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    font-size: 1rem;
    margin-bottom: 1rem;
    background: #f1f5f9;
    color: #334155;
    transition: border 0.2s;
  }
  .modal-form input[type="text"]:focus {
    border: 1.5px solid #ef4444;
    outline: none;
    background: #fff;
  }
  .modal-submit-btn {
    margin-top: 1.2rem;
    width: 100%;
    padding: 0.85rem;
    background: linear-gradient(90deg, #ef4444 70%, #dc2626 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1.08rem;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(239,68,68,0.08);
    transition: background 0.2s, box-shadow 0.2s;
  }
  .modal-submit-btn:hover {
    background: linear-gradient(90deg, #dc2626 70%, #ef4444 100%);
    box-shadow: 0 4px 16px rgba(239,68,68,0.13);
  }
</style>

<!-- Delete Database Modal -->
<div id="deleteModal" class="modalDel hidden">
  <div class="modal-overlay"></div>
  <div class="modal-contentD">
    <div class="modal-header">
      <h2 class="modal-title">Limpar Dados do Banco</h2>
      <button id="closeModalDel" class="modal-close-btn">&times;</button>
    </div>
    <p class="modal-subtitle">Selecione as tabelas que você deseja limpar ou limpe por nome de usuário:</p>
    <form id="deleteForm" class="modal-form">
      <label><input type="checkbox" id="selectAllTables">Selecionar Todas</label>
      <label><input type="checkbox" name="tables" value="table_data">Faturas Impressas</label>
      <label><input type="checkbox" name="tables" value="logins">Total de Logins</label>
      <label><input type="checkbox" name="tables" value="acessos">Total de Acessos</label>
      <label for="username">Limpar por nome de usuário:</label>
      <input type="text" id="username" name="username" placeholder="Digite o nome Ou vazio para limpar tudo">
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

  // Seletor de todas as tabelas
  document.getElementById('selectAllTables').addEventListener('change', function() {
    const checked = this.checked;
    document.querySelectorAll('input[name="tables"]').forEach(cb => {
      cb.checked = checked;
    });
  });

  deleteForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(deleteForm);
    const selectedTables = formData.getAll("tables");
    const username = formData.get("username");

    if (selectedTables.length === 0 && !username) {
      showToast('Selecione pelo menos uma tabela ou informe o nome do usuário para limpar', 'info');
      return;
    }

    fetch('./dados/delete-tables.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ tables: selectedTables, identity: username.trim() })
    }).then(res => res.json()).then(response => {
      if(response.success){
        fetchPainelData();
        showToast(response.message, 'success');
        modal.classList.add('hidden');
      }
    });
  });

</script>