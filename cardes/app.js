  var cardsData = [
    { id: 1, titulo: "so br", categoria: "Saúde", valor: 323.00, data: "25/09/2025" },
    { id: 2, titulo: "brasil sa", categoria: "Despesas de Casa", valor: 890.50, data: "12/10/2025" },
    { id: 3, titulo: "alpha co", categoria: "Transporte", valor: 1500.00, data: "01/11/2025" },
    { id: 4, titulo: "alp33ha co", categoria: "Compras", valor: 100.00, data: "01/11/2025" },
    { id: 5, titulo: "AAAAha co", categoria: "Lazer", valor: 400.00, data: "01/11/2025" },
    { id: 6, titulo: "qeer co", categoria: "Outros", valor: 40.00, data: "01/11/2025" },
  ];

  cardsData = [];

document.addEventListener("DOMContentLoaded", () => {
 
   const html = document.documentElement; // pega o <html>
  const toggleDarkBtn = document.getElementById("toggleDark"); // botão para alternar o tema

  // Verifica se já existe preferência salva
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "dark") {
    html.classList.add("dark");
  } else {
    html.classList.remove("dark");
  }

  // Alternar tema ao clicar
  toggleDarkBtn?.addEventListener("click", () => {
    if (html.classList.contains("dark")) {
      html.classList.remove("dark");
      localStorage.setItem("theme", "light"); // salva claro
    } else {
      html.classList.add("dark");
      localStorage.setItem("theme", "dark"); // salva escuro
    }
  });

  const container = document.getElementById("cards-container");
  const modal = document.getElementById("radix-:r4:");
  const modalOverlay = modal.previousElementSibling;
  const form = modal.querySelector("form");
  const inputTitulo = form.querySelector("#edit-description");
  const inputValor = form.querySelector("#edit-value");
  const inputCategoria = form.querySelector("select");
  const inputData = form.querySelector("#edit-dueDate");
  const btnClose = modal.querySelector("button[aria-label='Close'], .sr-only");
  const searchInput = document.querySelector('input[placeholder="Pesquisar contas..."]');
  const categoryBtn = document.querySelector("button[role='combobox']");
  const CardConts = document.querySelectorAll('[class="text-sm"]');
  const totalConts = document.querySelectorAll('.total');

  function formatCentsToBRL(value) {
    if (!value) return "";

    return Number(value).toLocaleString("pt-BR", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  function formatCentsToBRLL(cents) {
    const n = Number(cents || 0) / 100;
    return n.toLocaleString("pt-BR", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

inputValor.addEventListener("input", (e) => {
  let digits = e.target.value.replace(/\D/g, ""); // só números
  if (digits === "") digits = "0";

  const cents = parseInt(digits, 10);
  e.target.dataset.cents = cents; // guarda o valor real em centavos
  e.target.value = formatCentsToBRLL(cents);

  // força o cursor pro final (senão ele fica pulando)
  setTimeout(() => {
    e.target.setSelectionRange(e.target.value.length, e.target.value.length);
  }, 0);
});

  const categorySelect = categoryBtn.nextElementSibling;

  let editingId = null;
  let currentFilter = { search: "", categoria: "" };

  var cardClass = {'Saúde':'saude','Despesas de Casa':'despesasdecasa','Transporte':'transporte','Compras':'compras','Lazer':'lazer', 'Outros':'outros'};

  function renderCards() {
    var ValorTotal = 0.00;
    container.innerHTML = "";

    CardConts.forEach(item => {
      item.innerHTML = `${cardsData.length} contas`;
    });
    
  function removeAccents(str) {
  return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

const filtered = cardsData.filter(card => {
  const searchTerm = removeAccents(currentFilter.search);
  const matchSearch = 
    removeAccents(card.titulo).includes(searchTerm) || 
    removeAccents(card.categoria).includes(searchTerm);

  const matchCategoria = currentFilter.categoria === "" || removeAccents(card.categoria) === removeAccents(currentFilter.categoria);

  return matchSearch && matchCategoria;
});

     filtered.forEach(card => {

      ValorTotal = parseFloat(ValorTotal)+parseFloat(card.valor);

      const el = document.createElement("div");
      el.className = "rounded-xl border bg-card text-card-foreground shadow group hover:shadow-lg transition-all duration-300 hover:-translate-y-1 border-l-4 border-l-slate-600 dark:border-l-slate-400";
      el.innerHTML = `
        <div class="flex flex-col space-y-1.5 p-6 pb-3">
          <div class="flex justify-between items-start">
            <div class="flex-1">
              <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-2">${card.titulo}</h3>
              <div class="${cardClass[card.categoria]} inline-flex items-center rounded-md border px-2.5 py-0.5 bg-green-100 text-green-800 text-xs font-medium">
                ${card.categoria}
              </div>
            </div>
            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
              <button class="hover:bg-blue-50 dark:hover:bg-blue-900/20 h-8 rounded-md px-3 text-xs" data-id="${card.id}" data-action="edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen h-4 w-4" aria-hidden="true"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg></button>
              <button class="hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 h-8 rounded-md px-3 text-xs" data-id="${card.id}" data-action="delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2 lucide-trash-2 h-4 w-4" aria-hidden="true"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg></button>
            </div>
          </div>
        </div>
        <div class="p-6 pt-0">
          <div class="flex justify-between items-center">
            <div class="text-2xl font-bold text-slate-800 dark:text-slate-200">R$&nbsp;${formatCentsToBRL(card.valor)}</div>
            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-calendar h-4 w-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
              ${card.data}
            </div>
          </div>
        </div>
      `;
      container.appendChild(el);
    });

    totalConts.forEach(item => {
      item.innerHTML = `${formatCentsToBRL(ValorTotal)}`;
    });
  }

  function openModal(card = null) {
    modalOverlay.style.display = "block";
    modal.style.display = "grid";
    editingId = card?.id || null;

    if (card) {
        // Preenche título e valor
        inputTitulo.value = card.titulo;
        inputValor.value = formatCentsToBRL(card.valor); // mantém a formatação BRL

        // --- Dropdown customizado ---
        selectHidden.value = card.categoria; // seleciona a opção no select real
        comboBtn.querySelector("span").textContent = card.categoria; // atualiza o botão visual

        // --- Input de data ---
        // card.data vem no formato dd/mm/yyyy
        document.querySelector("#edit-dueDate").value  = card.data; // yyyy-mm-dd
    } else {
        // Modal para adicionar novo card
        inputTitulo.value = "";
        inputValor.value = "";
        selectHidden.value = "";
        comboBtn.querySelector("span").textContent = "Selecione";
        inputData.value = new Date().toISOString().split("T")[0];
    }
}


  function closeModal() {
    modalOverlay.style.display = "none";
    modal.style.display = "none";
  }

    document.querySelector(".closeModal").addEventListener("click", e => {
        closeModal();
     });
     
   document.querySelector(".closeModall").addEventListener("click", e => {
        closeModal();
     });

  // Eventos de edição/exclusão
  container.addEventListener("click", e => {
    const btn = e.target.closest("button");
    if (!btn) return;
    const id = parseInt(btn.dataset.id);
    const action = btn.dataset.action;
    const card = cardsData.find(c => c.id === id);

    if (action === "edit" && card) openModal(card);
    if (action === "delete") {
      cardsData = cardsData.filter(c => c.id !== id);
      renderCards();
    }
  });

  function formatToNumber(value) {
  if (!value) return "";

  // Remove pontos (separador de milhar) e troca vírgula por ponto
  let formatted = value.replace(/\./g, "").replace(",", ".");
  
  return parseFloat(formatted);
}

  // Botão Adicionar Conta
  document.querySelector(".AdicionarCod")?.addEventListener("click", () => openModal());

  // Fechar modal
  btnClose.addEventListener("click", closeModal);
  modalOverlay.addEventListener("click", closeModal);

  // Submeter form
form.addEventListener("submit", e => {
    e.preventDefault();
    const titulo = inputTitulo.value.trim();
    const valor = parseFloat(inputValor.value.replace(",", "."));
    const categoria = inputCategoria.value;
    const dataParts = inputData.value.split("-");
    const data = `${dataParts[0]}-${dataParts[1]}-${dataParts[2]}`; // yyyy-mm-dd

    if(!titulo || isNaN(valor)) return alert("Preencha todos os campos corretamente!");

    // Se estiver editando, chama update
    if(editingId) {
        fetch("cards_actions.php?action=update", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${editingId}&titulo=${encodeURIComponent(titulo)}&categoria=${encodeURIComponent(categoria)}&valor=${valor}&data=${data}`
        }).then(res => res.json())
          .then(() => fetchCards());
    } else { // Se não, adiciona novo card
        fetch("cards_actions.php?action=add", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `titulo=${encodeURIComponent(titulo)}&categoria=${encodeURIComponent(categoria)}&valor=${valor}&data=${data}`
        }).then(res => res.json())
          .then(() => fetchCards());
    }

    closeModal();
});


  // Filtro de pesquisa
  searchInput.addEventListener("input", e => {
    currentFilter.search = e.target.value;
    renderCards();
  });

  // Filtro por categoria
  categorySelect.addEventListener("change", e => {
    currentFilter.categoria = e.target.value === "" ? "" : e.target.value;
    categoryBtn.querySelector("span").textContent = e.target.selectedOptions[0].textContent;
    renderCards();
  });

const btn = document.getElementById("categoryBtn"); // botão principal
const dropdown = document.getElementById("dropdown"); // o menu
const items = dropdown.querySelectorAll(".dropdown-item"); // opções do menu

// Abrir/fechar dropdown
btn.addEventListener("click", () => {
  dropdown.classList.toggle("hidden");
});

// Selecionar categoria e aplicar filtro
items.forEach(item => {
  item.addEventListener("click", () => {
    let categoriaSelecionada = item.textContent.replace("✔", "").trim();

    if (categoriaSelecionada === "Todas as categorias") {
      currentFilter.categoria = ""; // sem filtro
    } else {
      currentFilter.categoria = categoriaSelecionada;
    }

    // Atualiza o texto do botão
    btn.querySelector("span").textContent = categoriaSelecionada;

    // Atualiza marca visual (check)
    items.forEach(i => i.querySelector(".check").classList.add("hidden"));
    item.querySelector(".check").classList.remove("hidden");

    // Fecha o dropdown
    dropdown.classList.add("hidden");

    // Re-renderiza os cards filtrados
    renderCards();
  });
});

// Fecha o dropdown ao clicar fora
document.addEventListener("click", (e) => {
  if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
    dropdown.classList.add("hidden");
  }
});
 

 renderCards();

 function fetchCards() {
    fetch("cards_actions.php?action=list")
        .then(res => res.json())
        .then(data => {
            cardsData = data.map(c => ({
                ...c,
                valor: parseFloat(c.valor) // garante número
            }));
            renderCards();
        });
}
fetchCards()
const comboBtn = document.getElementById("boxselectbtn");
const selectHidden = document.getElementById("boxselect");

    if (!comboBtn || !selectHidden) return;

    const dropdownContainer = document.createElement("div");
    dropdownContainer.className = "dropdown-visual hidden flex-col rounded-md bg-gray-900 border border-gray-700 shadow-lg";

    Array.from(selectHidden.options).forEach(opt => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "dropdown-item px-3 py-2 text-left text-sm hover:bg-gray-700";
        btn.textContent = opt.text;
        dropdownContainer.appendChild(btn);

        btn.addEventListener("click", () => {
            comboBtn.querySelector("span").textContent = opt.text;
            comboBtn.setAttribute("aria-expanded", "false");
            dropdownContainer.classList.add("hidden");
            selectHidden.value = opt.value;
        });
    });

    comboBtn.parentElement.appendChild(dropdownContainer); // <— anexado ao mesmo container relative

    comboBtn.addEventListener("click", () => {
        const isOpen = comboBtn.getAttribute("aria-expanded") === "true";
        comboBtn.setAttribute("aria-expanded", String(!isOpen));
        dropdownContainer.classList.toggle("hidden");
    });

    document.addEventListener("click", e => {
        if (!comboBtn.contains(e.target) && !dropdownContainer.contains(e.target)) {
            comboBtn.setAttribute("aria-expanded", "false");
            dropdownContainer.classList.add("hidden");
        }
    });


  // Eventos de edição/exclusão
container.addEventListener("click", e => {
    const btn = e.target.closest("button");
    if (!btn) return;
    const id = parseInt(btn.dataset.id);
    const action = btn.dataset.action;
    const card = cardsData.find(c => c.id === id);

    if (action === "edit" && card) {
        openModal(card);
    }

    // AQUI colocamos o DELETE via AJAX
    if (action === "delete") {
        fetch("cards_actions.php?action=delete", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}`
        })
        .then(res => res.json())
        .then(() => fetchCards()); // Recarrega os cards do banco
    }
});



});

