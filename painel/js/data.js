// Mock data for the admin dashboard
var dashboardStats = {};

var acessosData = [];

var loginsData = [];

var tableData = [];

function SessaoBox(e) {
    document.querySelectorAll('.table-section').forEach(item => {
        (item.dataset.date.includes(e)) ? item.style = '': item.style = 'display: none;';
     });
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