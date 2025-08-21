$(document).ready(function() {
    let cashInTable = $('#cashInTable').DataTable();
    let cashOutTable = $('#cashOutTable').DataTable();
    let editingRowIndex = null;
    let editingCashInRow = null; 

    function updateNetEarnings() {
let totalCashIn = 0, totalCashOut = 0;

cashInTable.rows().data().each(function(value) {
    totalCashIn += parseFloat(value[1].replace('₱', '').replace(',', '')) || 0;
});

cashOutTable.rows().data().each(function(value) {
    totalCashOut += parseFloat(value[3].replace('₱', '').replace(',', '')) || 0;
});

let netEarnings = totalCashIn - totalCashOut;

$('#totalCashIn').text('₱' + totalCashIn.toLocaleString('en-US', {minimumFractionDigits: 2}));
$('#totalCashOut').text('₱' + totalCashOut.toLocaleString('en-US', {minimumFractionDigits: 2}));
$('#totalFunds').text('₱' + netEarnings.toLocaleString('en-US', {minimumFractionDigits: 2}));
}


    $('#addNewCashIn').click(function() {
        editingCashInRow = null; 
        $('#cashInMonth, #cashInAmount').val('');
        $('#cashInModal').fadeIn();
    });

    $('#saveCashIn').click(function() {
        let month = $('#cashInMonth').val();
        let amount = $('#cashInAmount').val();

        if (editingCashInRow !== null) {
            cashInTable.row(editingCashInRow).data([month, '₱' + amount, '<button class="editBtn">Edit</button> <button class="deleteBtn">Delete</button>']).draw();
        } else {
            cashInTable.row.add([month, '₱' + amount, '<button class="editBtn">Edit</button> <button class="deleteBtn">Delete</button>']).draw();
        }

        $('#cashInModal').fadeOut();
        updateNetEarnings();
    });

    $('#cashInTable tbody').on('click', '.editBtn', function() {
        editingCashInRow = cashInTable.row($(this).parents('tr')).index();
        let data = cashInTable.row(editingCashInRow).data();
        $('#cashInMonth').val(data[0]);
        $('#cashInAmount').val(data[1].replace('₱', ''));
        $('#cashInModal').fadeIn();
    });

    $('#cashInTable tbody').on('click', '.deleteBtn', function() {
        cashInTable.row($(this).parents('tr')).remove().draw();
        updateNetEarnings();
    });

    $('#addNewExpense').click(function() {
        editingRowIndex = null;
        $('#cashOutDate, #cashOutDetail, #cashOutCategory, #cashOutAmount').val('');
        $('#cashOutModal').fadeIn();
    });

    $('#saveCashOut').click(function() {
        let date = $('#cashOutDate').val();
        let detail = $('#cashOutDetail').val();
        let category = $('#cashOutCategory').val();
        let amount = $('#cashOutAmount').val();

        if (editingRowIndex !== null) {
            cashOutTable.row(editingRowIndex).data([date, detail, category, '₱' + amount, '<button class="editBtn">Edit</button> <button class="deleteBtn">Delete</button>']).draw();
        } else {
            cashOutTable.row.add([date, detail, category, '₱' + amount, '<button class="editBtn">Edit</button> <button class="deleteBtn">Delete</button>']).draw();
        }

        $('#cashOutModal').fadeOut();
        updateNetEarnings();
    });

    $('#cashOutTable tbody').on('click', '.editBtn', function() {
        editingRowIndex = cashOutTable.row($(this).parents('tr')).index();
        let data = cashOutTable.row(editingRowIndex).data();
        $('#cashOutDate').val(data[0]);
        $('#cashOutDetail').val(data[1]);
        $('#cashOutCategory').val(data[2]);
        $('#cashOutAmount').val(data[3].replace('₱', ''));
        $('#cashOutModal').fadeIn();
    });

    $('#cashOutTable tbody').on('click', '.deleteBtn', function() {
        cashOutTable.row($(this).parents('tr')).remove().draw();
        updateNetEarnings();
    });
});

$('.modal').click(function(event) {
if ($(event.target).hasClass('modal')) {
    $(this).fadeOut();
}
});
