// Mock data for the admin dashboard
var dashboardStats = {};

var acessosData = [];

var loginsData = [];

var tableData = [];

function SessaoBox(e) {
    const sections = document.querySelectorAll('.table-section[data-date]');
    let targetSection = null;

    sections.forEach(item => {
        const matches = (item.dataset.date || '').includes(e);
        item.style.display = matches ? '' : 'none';

        if (matches && !targetSection) {
            targetSection = item;
        }
    });

    if (targetSection) {
        targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

const getStatusColor = (status) => {
    switch (status) {
        case 'pago':
            return 'status-pago';
        case 'pendente':
            return 'status-pendente';
        case 'cancelado':
            return 'status-cancelado';
        default:
            return 'status-pendente';
    }
};

var formatCurrency = (value) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(value);
};

const formatNumber = (value) => {
    return new Intl.NumberFormat('pt-BR').format(value);
};
