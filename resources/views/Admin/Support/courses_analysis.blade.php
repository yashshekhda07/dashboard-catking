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

    .whatsapp_group_progress_unfilled {
        background: #DDE5FF
    }

    .chatbot_progress_unfilled {
        background: #FFD9D9;
    }

    .chatbot_progress_filled {
        background: #8BC9B4;
    }

    .word_cloud_container {
        display: flex;
        justify-content: center;
    }

    .word_cloud {
        display: flex;
        justify-content: center;
        width: 100% !important;
        height: 400px !important;
    }

    .negative_words_cloud {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<script src="{{ asset('assets/js/chart-wordcloud.js') }}"></script>
<script>
    $(document).ready(function () {
        var loaderSelector = `.course_customer_success_calls_loader`;
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        try {
            $(loaderSelector).show();
            var date = $('input[name="date"]:checked').val();
            var coursesCustomerSuccessCalls = $.ajax({
                url: '{{ route('support.coursesCustomerSuccessCalls') }}',
                type: 'GET',
                data: {
                    date,
                    startDate,
                    endDate
                },
                success: function (res) {
                    var table = '';
                    if (res.courses_analysis_data.length > 0) {
                        $.each(res.courses_analysis_data, function (item, course) {
                            table += `<tr>
                                    <td scope="row" class="text-center text-primary">${course.name}</td>
                                    <td class="text-center fw-semibold">${course.total_calls}</td>
                                    <td class="text-center fw-semibold">${course.answered_calls}</td>
                                    <td class="text-center fw-semibold">${course.unanswered_calls}</td>
                                    <td class="text-center fw-semibold">${course.missed_calls}</td>
                                    <td class="text-center fw-semibold">0</td>
                                </tr>`;
                        });
                        $('.tableData').html(table);
                    } else {
                        table += `<tr>
                                    <td scope="row" class="text-center" colspan="6"><h3 class="m-0">No data Found</h3></td>
                                </tr>`;
                        $('.tableData').html(table);
                    }
                    $(loaderSelector).fadeOut('slow');
                }
            })
        } catch (error) {
            $(loaderSelector).fadeOut('slow');
            console.error('Error fetching call and group count:', error);
        }

    })

    var randomColors = ["#0C82FE", "#7270EF", "#05683E", "#72B8FE", "#8BC9B4", '#88A4FF'];
    var randomColorsNegative = ["#FF4D31", "#FA9C2F", "#D92424", "#FF718B", "#FA9C2F", "#FF8B7B"];

    function createWordCloudChart(elementId, words, colors) {
        if (words.length > 0) {
            new Chart(document.getElementById(elementId).getContext("2d"), {
                type: "wordCloud",
                data: {
                    labels: words.map((d) => d.key),
                    datasets: [{
                        label: "",
                        data: words.map((d) => 10 + d.value * 10)
                    }]
                },
                options: {
                    title: {
                        display: false,
                        text: "Chart.js Word Cloud"
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        },
                        title: {
                            display: false,
                            text: "Chart.js Word Cloud"
                        }
                    },
                    elements: {
                        word: {
                            color: function () {
                                return colors[Math.floor(Math.random() * colors.length)];
                            },
                            hoverColor: function () {
                                return colors[Math.floor(Math.random() * colors.length)];
                            }
                        },
                    },
                }
            });
        } else {
            $(`#${elementId}`).html('<h2>No words found.</h2>');
        }
    }

    function fetchWordsAndCreateChart(type, elementId, colors) {
        var fetchWordsAndCreateChart = $.ajax({
            url: "{{ route('support.getWords') }}",
            type: "get",
            data: {
                type: type
            },
            success: function (res) {
                createWordCloudChart(elementId, res.words, colors);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching:', error);
            }
        });
        activeAjaxRequests.push(fetchWordsAndCreateChart);
    }

    // Fetch positive words and create chart
    fetchWordsAndCreateChart("positive", "positive_word_cloud", randomColors);

    // Fetch negative words and create chart
    fetchWordsAndCreateChart("negative", "negative_word_cloud", randomColorsNegative);
</script>

<div class="courses_analysis">
    <div class="container-fluid container-side-padding">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 p-0">
                <div class="card card_box_shadow p-0">
                    <div class="card-body p-0 card_table_container">
                        <div class="data_loader course_customer_success_calls_loader">
                            <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" stroke="#027AFB">
                                <g fill="none" fill-rule="evenodd" stroke-width="2">
                                    <circle cx="22" cy="22" r="1">
                                        <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/>
                                        <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/>
                                    </circle>
                                    <circle cx="22" cy="22" r="1">
                                        <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite"/>
                                        <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"/>
                                    </circle>
                                </g>
                            </svg>
                        </div>
                        <table class="table">
                            <p class="p-3 table_title">Customer Success (CS) Calls</p>
                            <thead>
                            <tr>
                                <th scope="col">Course Name</th>
                                <th scope="col">Total Calls (CS)</th>
                                <th scope="col">Calls Answered</th>
                                <th scope="col">Unanswered Calls</th>
                                <th scope="col">Missed Calls</th>
                                <th scope="col">Major Feedback</th>
                            </tr>
                            </thead>
                            <tbody class="tableData"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid container-side-padding">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <div class="card card_box_shadow p-0">
                    <div class="card-body p-0">
                        <p class="p-3 table_title">Positive words cloud</p>
                        <div class="word_cloud_container">
                            <div class="word_cloud positive_words_cloud">
                                <canvas id="positive_word_cloud"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                <div class="card card_box_shadow p-0">
                    <div class="card-body p-0">
                        <table class="table">
                            <p class="p-3 table_title">Negative words cloud</p>
                            <div class="word_cloud_container">
                                <div class="word_cloud negative_words_cloud">
                                    <canvas id="negative_word_cloud"></canvas>
                                </div>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
