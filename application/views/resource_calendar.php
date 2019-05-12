<div class="content-wrapper">
    <section class="content-header">
        <h1 class="text-primary text-bold">
            Affectation des ressources
            <small>IN430</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">

                    <div class="box-body">
                        <label for="">Choisir un code couleur</label>
                        <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                            <ul class="fc-color-picker" id="color-chooser">
                                <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                            </ul>
                        </div>
                        <form id="resource-form">
                            <div class="input-group">
                                <label for="resource-type">Type de ressource</label>
                                <input id="resource-type" name="resource-type" type="text" class="form-control" placeholder="">
                            </div>
                            <div class="input-group">
                                <label for="resource">Ressource</label>
                                <input id="resource" name="resource" type="text" class="form-control" placeholder="Ressource">
                            </div>
                            <div class="input-group">
                                <label for="start">Date de début</label>
                                <input id="start" name="start" type="datetime-local" class="form-control">
                            </div>
                            <div class="input-group">
                                <label for="end">Date de fin</label>
                                <input id="end" name="end" type="datetime-local" class="form-control">
                            </div>
                            <hr>
                            <div class="input-group-btn">
                                <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>

    $(function () {

        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },
            //Random default events
            events: [
                {
                    title: 'All Day Event',
                    start: new Date(y, m, 1),
                    backgroundColor: '#f56954',
                    borderColor: '#f56954'
                },
                {
                    title: 'Long Event',
                    start: new Date(y, m, d - 5),
                    end: new Date(y, m, d - 2),
                    backgroundColor: '#f39c12',
                    borderColor: '#f39c12'
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false,
                    backgroundColor: '#0073b7',
                    borderColor: '#0073b7'
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false,
                    backgroundColor: '#00c0ef',
                    borderColor: '#00c0ef'
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d + 1, 19, 0),
                    end: new Date(y, m, d + 1, 22, 30),
                    allDay: false,
                    backgroundColor: '#00a65a',
                    borderColor: '#00a65a'
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/',
                    backgroundColor: '#3c8dbc',
                    borderColor: '#3c8dbc'
                }
            ],
            editable: true
        });

        /* ADDING EVENTS */

        let currColor = '#3c8dbc';

        $('#color-chooser > li > a').click(function (e) {
            e.preventDefault();
            //Save color
            currColor = $(this).css('color');
            //Add color effect to button
            $('#add-new-event').css({'background-color': currColor, 'border-color': currColor})
        });

        $('#add-new-event').click(function (e) {
            e.preventDefault();

            //Get value and make sure it is not null
            let resource = $('#resource').val();
            if (resource.length == 0) {
                return
            }

            let start = new Date($('#start').val());
            let end = new Date($('#end').val());

            // retrieve the dropped element's stored Event Object
            let originalEventObject = $(this).data('eventObject');


            // we need to copy it, so that multiple events don't have a reference to the same object
            let copiedEventObject = $.extend({}, originalEventObject);

            copiedEventObject.start = start;
            copiedEventObject.end = end;
            copiedEventObject.title = resource;
            copiedEventObject.backgroundColor = $(this).css('background-color');
            copiedEventObject.borderColor = $(this).css('border-color');

            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            // Reset the form
            // $('#resource-form').trigger('reset');
        });
    })
</script>