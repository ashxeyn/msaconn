// ANAYLTICS FUNCTIONS  
$(document).ready(function() {
    $('.input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
    
    loadCashFlowData();
    loadVolunteerStats();
    loadDashboardStats();
    
    $('.filter-date').change(function() {
        applyFilters();
    });
    
    $('#clearDate').click(function() {
        $('#sDate').val('');
        $('#eDate').val('');
        applyFilters();
    });
    
    function applyFilters() {
        const startDate = $('#sDate').val();
        const endDate = $('#eDate').val();
        
        loadCashFlowData(startDate, endDate);
        loadVolunteerStats(startDate, endDate);
        loadDashboardStats(startDate, endDate);
    }
});

function loadCashFlowData(startDate = '', endDate = '') {
    $.ajax({
        url: "../../handler/admin/getCashFlow.php",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate
        },
        success: function(response) {
            console.log("API Response:", response); 
            try {
                const data = JSON.parse(response);
                const months = data.map(item => item.month);
                const cashIn = data.map(item => item.total_cashin);
                const cashOut = data.map(item => item.total_cashout);
                const netMoney = data.map(item => item.net_money);

                const ctx = document.getElementById('transparencyChart').getContext('2d');
                
                if (window.transparencyChartInstance) {
                    window.transparencyChartInstance.destroy();
                }

                window.transparencyChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'Cash In',
                                data: cashIn,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Cash Out',
                                data: cashOut,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Net Money',
                                data: netMoney,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Amount'
                                }
                            }
                        }
                    }
                });
            } catch (e) {
                console.log(e);
                console.error("Invalid JSON response:", response);
                alert("Error loading cash flow data.");
            }
        },
        error: function() {
            alert("An error occurred while fetching cash flow data.");
        }
    });
}

function loadVolunteerStats(startDate = '', endDate = '') {
    $.ajax({
        url: "../../handler/admin/getStats.php",
        type: "GET",
        dataType: "json",
        data: {
            start_date: startDate,
            end_date: endDate
        },
        success: function(response) {
            let months = response.map(item => item.month);
            let totals = response.map(item => item.total);

            let ctx = document.getElementById('volunteersChart').getContext('2d');
            
            if (window.volunteersChartInstance) {
                window.volunteersChartInstance.destroy();
            }

            window.volunteersChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Volunteers Registered',
                        data: totals,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        },
        error: function() {
            console.error("Failed to load volunteer data.");
        }
    }); 
}

function loadDashboardStats(startDate = '', endDate = '') {
    $.ajax({
        url: "../../handler/admin/getDashboardStats.php",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate
        },
        success: function(response) {
            try {
                const data = JSON.parse(response);
                $('#analyticsContent .stats-container .stat-card:nth-child(1) .stat-number').text(data.volunteers);
                $('#analyticsContent .stats-container .stat-card:nth-child(2) .stat-number').text(data.pending);
                $('#analyticsContent .stats-container .stat-card:nth-child(3) .stat-number').text(data.moderators);
            } catch (e) {
                console.error("Invalid JSON response for dashboard stats:", e);
            }
        },
        error: function() {
            console.error("Failed to load dashboard stats.");
        }
    });
}

$(document).ready(function() {
    loadCashFlowData();
    loadVolunteerStats();
    loadDashboardStats();
});