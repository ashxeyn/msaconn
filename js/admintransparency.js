$(document).ready(function() {
    let cashInTable = $('#cashInTable').DataTable();
    let cashOutTable = $('#cashOutTable').DataTable();
    let editingRowIndex = null;
    let editingCashInRow = null; // Track Cash-In edits

    function updateNetEarnings() {
let totalCashIn = 0, totalCashOut = 0;

// Calculate total Cash-In
cashInTable.rows().data().each(function(value) {
    totalCashIn += parseFloat(value[1].replace('₱', '').replace(',', '')) || 0;
});

// Calculate total Cash-Out
cashOutTable.rows().data().each(function(value) {
    totalCashOut += parseFloat(value[3].replace('₱', '').replace(',', '')) || 0;
});

// Calculate Net Funds
let netEarnings = totalCashIn - totalCashOut;

// Update the table
$('#totalCashIn').text('₱' + totalCashIn.toLocaleString('en-US', {minimumFractionDigits: 2}));
$('#totalCashOut').text('₱' + totalCashOut.toLocaleString('en-US', {minimumFractionDigits: 2}));
$('#totalFunds').text('₱' + netEarnings.toLocaleString('en-US', {minimumFractionDigits: 2}));
}


    // **Cash-In Add/Edit**
    $('#addNewCashIn').click(function() {
        editingCashInRow = null; // Reset editing mode
        $('#cashInMonth, #cashInAmount').val('');
        $('#cashInModal').fadeIn();
    });

    $('#saveCashIn').click(function() {
        let month = $('#cashInMonth').val();
        let amount = $('#cashInAmount').val();

        if (editingCashInRow !== null) {
            // **Editing Existing Row**
            cashInTable.row(editingCashInRow).data([month, '₱' + amount, '<button class="editBtn">Edit</button> <button class="deleteBtn">Delete</button>']).draw();
        } else {
            // **Adding New Row**
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

    // **Cash-Out Add/Edit**
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
            // **Editing Existing Row**
            cashOutTable.row(editingRowIndex).data([date, detail, category, '₱' + amount, '<button class="editBtn">Edit</button> <button class="deleteBtn">Delete</button>']).draw();
        } else {
            // **Adding New Row**
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

// Close modal when clicking the background
$('.modal').click(function(event) {
if ($(event.target).hasClass('modal')) {
    $(this).fadeOut();
}
});
