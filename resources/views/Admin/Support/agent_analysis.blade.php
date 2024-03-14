<style>
    .table_title {
        color: #302F2F;
        text-align: center;
        background: #ECF6FF;
        font-family: "Poppins", sans-serif;
        font-size: 18px;
        font-weight: 600;
        line-height: 22px;
        letter-spacing: 0;
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
    }

    th {
        text-align: center !important;
    }

    .recognize_dot {
        margin-right: 5px;
        margin-top: -1px;
    }

    .card {
        width: 100%;
    }

    .container-side-padding {
        padding: 20px !important;
    }

    .chat_ticket_progress_unfilled {
        background: #FFD9D9
    }

    .chat_ticket_progress_unfilled .progress-bar {
        background: #8BC9B4
    }

    .whatsapp_group_progress_unfilled {
        background: #FFD9D9
    }

    .whatsapp_group_progress_unfilled .progress {
        background: #DDE5FF
    }

    .page_links,
    .dynamicPageLink {
        display: flex;
        justify-content: end;
    }

    .page_button {
        padding: 18px;
        background: #ECF6FF;
        width: 45px;
        height: 45px;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: black;
        font-weight: bold;
        margin-bottom: 10px;
        margin-right: 10px;
        cursor: pointer;
        margin-top: 15px;
    }

    .page_button.active {
        background-color: rgba(12, 131, 255) !important;
        color: white;
    }

    .page_button:hover {
        background: rgba(12, 131, 255, 0.8) !important;
        color: white;
        transition: all 0.3s ease-in-out`;
    }

    .first_page_button, .last_page_button {
        padding: 8px;
    }

    .first_page_button svg, .last_page_button svg{
        width: 15px;
    }

    .next_page_button,.last_page_button {
        transform: rotate(180deg);
    }

    .table_head {
        position: relative;
    }

    .table_head input[type="search"] {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translate(-10%, -50%);
        width: 20%;
    }
</style>
<script>
    $(document).ready(function() {
        emailTicketsChart();
        incomingOutgoingCallsData();
    })

    function emailTicketsChart() {
        $('.chatbot_ticket_loader').show();
        let emailTicketChart = document.getElementById('emailTicketChart').getContext('2d');
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var date = $('input[name="date"]:checked').val();
        var emailTicketsChart = $.ajax({
            url: '{{ route('support.emailTicketsChart') }}',
            type: 'GET',
            data: {
                date,
                startDate,
                endDate
            },
            success: function(res) {
                const chatData = res.chat_tickets_data;
                let chatDataHtml = '';
                if (chatData.length === 0) {
                    $('.chatbot_ticket_loader').fadeOut('slow');
                    $('.chatTicketData').html(
                        `<tr><td colspan="2"><h3 class="mb-0 text-center">No Ticket found</h3></td></tr>`
                    );
                } else {
                    $.each(chatData, function(index, item) {
                        var totalTickets = parseInt(item.ticket_resolved) + parseInt(item
                            .ticket_pending);
                        var resolvedTicketsPercentage = totalTickets > 0 ? Math.round((parseInt(item
                            .ticket_resolved) * 100) / totalTickets) : 0;
                        var pendingTicketsPercentage = totalTickets > 0 ? Math.round((parseInt(item
                            .ticket_pending) * 100) / totalTickets) : 0;

                        chatDataHtml += `
                        <tr>
                            <td scope="row" class="text-center">${index}</td>
                            <td class="text-end">
                                <div class="progress chat_ticket_progress_unfilled">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                         role="progressbar" aria-label="Animated striped example"
                                         aria-valuenow="${resolvedTicketsPercentage}" aria-valuemin="0" aria-valuemax="100"
                                         style="width: ${resolvedTicketsPercentage}%">
                                        <div class="progress_pointer"></div>${resolvedTicketsPercentage}%
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                    });

                    $('.chatTicketData').html(chatDataHtml);
                    $('.chatbot_ticket_loader').fadeOut('slow');
                }

                const data = res.email_tickets_data;
                const labels = Object.keys(data);

                const dataSets = [{
                    label: 'Ticket Received',
                    backgroundColor: 'rgba(114, 184, 254, 1)',
                    borderColor: 'rgba(114, 184, 254, 1)',
                    borderWidth: 1,
                    barPercentage: 0.6,
                    categoryPercentage: 0.6,
                    borderRadius: 10,
                    data: [],
                }, {
                    label: 'Ticket Pending',
                    backgroundColor: 'rgba(255, 0, 0, 0.3)',
                    borderColor: 'rgba(255, 0, 0, 0.3)',
                    borderWidth: 1,
                    barPercentage: 0.6,
                    categoryPercentage: 0.6,
                    borderRadius: 10,
                    data: [],
                }, {
                    label: 'Ticket Resolved',
                    backgroundColor: 'rgba(138, 220, 192, 1)',
                    borderColor: 'rgba(138, 220, 192, 1)',
                    borderWidth: 1,
                    barPercentage: 0.6,
                    categoryPercentage: 0.6,
                    borderRadius: 10,
                    data: [],
                }];

                labels.forEach(function(label) {
                    dataSets[0].data.push(data[label]?.ticket_received ?? 0);
                    dataSets[1].data.push(data[label]?.ticket_pending ?? 0);
                    dataSets[2].data.push(data[label]?.ticket_resolved ?? 0);
                });

                if (labels.length === 0) {
                    new Chart(emailTicketChart, {
                        type: 'line',
                        data: {
                            labels: [],
                            datasets: [{
                                label: 'No data found',
                                data: [],
                                backgroundColor: 'rgba(255, 255, 255, 1)',
                                borderColor: 'rgba(255, 255, 255, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            barThickness: 10,
                            plugins: {
                                legend: {
                                    display: false // Hide legend
                                },
                                title: {
                                    display: true,
                                    text: 'No data found',
                                    font: {
                                        size: 18
                                    }
                                }
                            }
                        }
                    });
                } else {
                    new Chart(emailTicketChart, {
                        type: 'bar',
                        scaleSteps: 1,
                        data: {
                            labels: labels,
                            datasets: dataSets
                        },
                        options: {
                            barThickness: 10,
                        }
                    });
                }
            }
        });
    }

    function incomingOutgoingCallsData(page = 1, searchQuery) {
        $('.incoming_outgoing_calls_loader').show();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var date = $('input[name="date"]:checked').val();
        var routeUrl = `{{ route('support.incomingOutgoingCalls') }}?page=` + page;
        searchQuery = $('input[name="search"]').val();
        var incomingOutgoingCallsData = $.ajax({
            url: routeUrl,
            type: 'GET',
            data: {
                date,
                startDate,
                endDate,
                searchQuery
            },
            beforeSend: function() {
                incomingOutgoingCallsData?.abort();
                activeAjaxRequests.forEach(function(request, index) {
                    request.abort();
                    activeAjaxRequests.splice(index, 1);
                });
            },
            success: function(res) {
                const incomingOutgoingCallsData = res.incomingOutgoingCallsData_arr;
                const current_page = parseInt(res.current_page);
                const last_page = parseInt(res.last_page);
                // selectors
                let pageLinkContainer = $('.pageLinkContainer');
                // selectors
                if(Object.keys(incomingOutgoingCallsData).length > 0){
                    let incomingOutgoingCallsDataHtml = '';
                    $.each(incomingOutgoingCallsData, function(index, item) {
                        incomingOutgoingCallsDataHtml += `<tr>
                            <td scope="row" class="text-center">${index}</td>
                            <td class="text-center">${item.total_cs_or_welcome_calls}</td>
                            <td class="text-center">${item.total_connected_calls}</td>
                            <td class="text-center">${item.total_failed_calls}</td>
                            <td class="text-center">${item.total_duration}</td>
                            <td class="text-center">${item.total_avg_duration}</td>
                            <td class="text-center">0</td>
                        </tr>`;
                    })
                    $('.incomingOutgoingCallsData').html(incomingOutgoingCallsDataHtml);

                    let pageHtml = '';
                    let j = 1;
                    let iVal = (current_page !== 1 && current_page !== last_page) ? (current_page - 1) : (current_page === last_page) ? (current_page - 1) : current_page;
                    for (let i = iVal; i <= last_page; i++) {
                        let activeBtn = (current_page === i) ? "active" : "";
                        if (j === 1 && current_page === last_page) {
                            pageHtml += `<div class="page_button" onclick=incomingOutgoingCallsData('${1}')>
                                    1
                                </div>`;
                            pageHtml += `<div class="page_button">
                                    ...
                                </div>`;
                        }
                        pageHtml += `<div class="page_button ${activeBtn}" onclick=incomingOutgoingCallsData('${i}')>
                                    ${i}
                                </div>`;
                        if (j === 2 && current_page !== last_page) {
                            pageHtml += `<div class="page_button">
                                    ...
                                </div>`;
                            pageHtml += `<div class="page_button" onclick=incomingOutgoingCallsData('${last_page}')>
                                    ${last_page}
                                </div>`;
                        }
                        if (j === 2) break;
                        j++;
                    }
                    const previousPageButton = $('.previousPageButton');
                    if(current_page === 1) {
                        previousPageButton.removeAttr('onclick');
                        previousPageButton.attr('disabled', '').removeAttr('onclick');
                    } else {
                        previousPageButton.attr('onclick', 'incomingOutgoingCallsData(' + (current_page - 1) + ')')
                    }

                    const nextPageButton = $('.nextPageButton')
                    if(current_page === last_page) {
                        nextPageButton.removeAttr('onclick');
                        nextPageButton.attr('disabled', '').removeAttr('onclick');
                    } else {
                        nextPageButton.attr('onclick', 'incomingOutgoingCallsData(' + (current_page + 1) + ')')
                    }

                    $('.firstPageButton').attr('onclick', 'incomingOutgoingCallsData(1)')
                    $('.lastPageButton').attr('onclick', 'incomingOutgoingCallsData(' + last_page + ')')

                    $('.dynamicPageLink').html(pageHtml);
                    pageLinkContainer.fadeIn();
                } else {
                    let noDataFound = `<tr>
                            <td class="text-center" colspan="7"><h3>No data found</h3></td>
                        </tr>`;
                    $('.incomingOutgoingCallsData').html(noDataFound);
                    pageLinkContainer.hide();
                }
                $('.incoming_outgoing_calls_loader').fadeOut('slow');
            }
        })

        activeAjaxRequests.push(incomingOutgoingCallsData);
    }
</script>

<div class="agent_analysis">
    <div class="container-fluid container-side-padding">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 p-0">
                <div class="card card_box_shadow p-0">
                    <div class="card-body p-0 card_table_container">
                        <div class="data_loader incoming_outgoing_calls_loader" style="height: calc(100% - 65px) !important;top: 60px;">
                            <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg"
                                stroke="#027AFB">
                                <g fill="none" fill-rule="evenodd" stroke-width="2">
                                    <circle cx="22" cy="22" r="1">
                                        <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20"
                                            calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1"
                                            repeatCount="indefinite" />
                                        <animate attributeName="stroke-opacity" begin="0s" dur="1.8s"
                                            values="1; 0" calcMode="spline" keyTimes="0; 1"
                                            keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" />
                                    </circle>
                                    <circle cx="22" cy="22" r="1">
                                        <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20"
                                            calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1"
                                            repeatCount="indefinite" />
                                        <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s"
                                            values="1; 0" calcMode="spline" keyTimes="0; 1"
                                            keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" />
                                    </circle>
                                </g>
                            </svg>
                        </div>
                        <table class="table">
                            <div class="table_head">
                                <p class="p-3 table_title">Incoming+Outgoing calls</p>
                                <input type="search" name="search" class="form-control" placeholder="Search..." oninput="incomingOutgoingCallsData('1', this.value)">
                            </div>
                            <thead>
                                <tr>
                                    <th scope="col">Agent Name</th>
                                    <th scope="col">Total Calls (CS+Welcome)</th>
                                    <th scope="col">Connected</th>
                                    <th scope="col">Failed</th>
                                    <th scope="col">Total Talktime</th>
                                    <th scope="col">Average Talktime</th>
                                    <th scope="col">Leave Taken</th>
                                </tr>
                            </thead>
                            <tbody class="incomingOutgoingCallsData">
                            </tbody>
                        </table>
                        <div class="page_links_container pageLinkContainer">
                            <div class="page_links">
                                <div class="page_button previousPageButton">
                                    <svg fill="#000000" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M441.751,475.584L222.166,256L441.75,36.416c6.101-6.101,7.936-15.275,4.629-23.253C443.094,5.184,435.286,0,426.667,0 H320.001c-5.675,0-11.093,2.24-15.083,6.251L70.251,240.917c-8.341,8.341-8.341,21.824,0,30.165l234.667,234.667 c3.989,4.011,9.408,6.251,15.083,6.251h106.667c8.619,0,16.427-5.184,19.712-13.163 C449.687,490.858,447.852,481.685,441.751,475.584z"></path> </g> </g> </g></svg>
                                </div>
                                <div class="dynamicPageLink">
                                    <div class="page_button">
                                        1
                                    </div>
                                </div>
                                <div class="page_button nextPageButton next_page_button">
                                    <svg fill="#000000" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M441.751,475.584L222.166,256L441.75,36.416c6.101-6.101,7.936-15.275,4.629-23.253C443.094,5.184,435.286,0,426.667,0 H320.001c-5.675,0-11.093,2.24-15.083,6.251L70.251,240.917c-8.341,8.341-8.341,21.824,0,30.165l234.667,234.667 c3.989,4.011,9.408,6.251,15.083,6.251h106.667c8.619,0,16.427-5.184,19.712-13.163 C449.687,490.858,447.852,481.685,441.751,475.584z"></path> </g> </g> </g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="card card_box_shadow p-0">
                            <div class="card-body p-0">
                                <table class="table">
                                    <p class="p-3 table_title">Whatsapp group addition</p>
                                    <thead>
                                        <tr>
                                            <th scope="col">Agent Name</th>
                                            <th scope="col">
                                                <svg width="12" height="12" class="recognize_dot">
                                                    <circle cx="6" cy="6" r="6" fill="#DDE5FF" />
                                                </svg>
                                                Number of leads assigned
                                            </th>
                                            <th scope="col">
                                                <svg width="12" height="12" class="recognize_dot">
                                                    <circle cx="6" cy="6" r="6" fill="#6186FF" />
                                                </svg>
                                                Successful additions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td scope="row" class="text-center">Aayushi</td>
                                            <td class="text-end w-50">
                                                <div class="progress whatsapp_group_progress_unfilled">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="10" style="width: 80%">
                                                        <div class="progress_pointer"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="card card_box_shadow p-0">
                            <div class="card-body p-0 card_table_container">
                                <div class="data_loader chatbot_ticket_loader">
                                    <svg width="44" height="44" viewBox="0 0 44 44"
                                        xmlns="http://www.w3.org/2000/svg" stroke="#027AFB">
                                        <g fill="none" fill-rule="evenodd" stroke-width="2">
                                            <circle cx="22" cy="22" r="1">
                                                <animate attributeName="r" begin="0s" dur="1.8s"
                                                    values="1; 20" calcMode="spline" keyTimes="0; 1"
                                                    keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" />
                                                <animate attributeName="stroke-opacity" begin="0s" dur="1.8s"
                                                    values="1; 0" calcMode="spline" keyTimes="0; 1"
                                                    keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" />
                                            </circle>
                                            <circle cx="22" cy="22" r="1">
                                                <animate attributeName="r" begin="-0.9s" dur="1.8s"
                                                    values="1; 20" calcMode="spline" keyTimes="0; 1"
                                                    keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" />
                                                <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s"
                                                    values="1; 0" calcMode="spline" keyTimes="0; 1"
                                                    keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" />
                                            </circle>
                                        </g>
                                    </svg>
                                </div>
                                <table class="table">
                                    <p class="p-3 table_title">Chatbot tickets</p>
                                    <thead>
                                        <tr>
                                            <th scope="col" >Tickets assigned</th>
                                            <th scope="col" colspan="2">
                                                <span class="ticketLabel me-2">
                                                    <svg width="12" height="12" class="recognize_dot">
                                                        <circle cx="6" cy="6" r="6" fill="#8BC9B4" />
                                                    </svg>
                                                    Tickets resolved
                                                </span>
                                                <span class="ticketLabel">
                                                    <svg width="12" height="12" class="recognize_dot">
                                                        <circle cx="6" cy="6" r="6" fill="#FFD9D9" />
                                                    </svg>
                                                    Tickets pending
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="chatTicketData"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid container-side-padding">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 p-0">
                        <div class="card card_box_shadow p-0">
                            <div class="card-body p-0">
                                <p class="p-3 table_title">Email tickets</p>
                                <div style="height: 500px;width: 100%;" class="p-3">
                                    <canvas id="emailTicketChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
