<?php
$levelIdIsSet = isset($levelId);
$lessonsAreEmpty = empty($lessons);
?>
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

                        <!-- SELECT CLASS CALENDAR -->
                        <form id="search" name="search" method="post" action="<?= base_url() ?>resource_allocation">
                            <?php if (!empty($levels)): ?>
                                <div class="form-group">
                                    <label for="level">Classes</label>
                                    <select class="form-control searchForm required" id="level" name="level">
                                        <option value="0">Sélectionnez le niveau d'études</option>
                                        <?php foreach ($levels as $level): ?>
                                            <option value="<?= $level->id ?>" <?php if (isset($levelId) && $level->id == $levelId) {
                                                echo 'selected=selected';
                                            } ?>>
                                                <?= $level->name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <?php if ($levelIdIsSet): ?>

                                <?php if (!$lessonsAreEmpty): ?>
                                    <div class="form-group hiddenField">
                                        <label for="lesson">Unité d'enseignement</label>
                                        <select class="form-control searchForm required" id="lesson" name="lesson">
                                            <option value="">Sélectionnez l'unité d'enseignement</option>
                                            <?php foreach ($lessons as $lesson): ?>
                                                <option value="<?= $lesson->id ?>" <?php if (isset($lessonId) && $lesson->id == $lessonId) {
                                                    echo 'selected=selected';
                                                } ?>>
                                                    <?= $lesson->label ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group hiddenField">
                                    <label for="start">Date de début</label>
                                    <div class='input-group datetimepicker'>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                        </span>
                                        <input type='text'
                                               class="form-control"
                                               id="start"
                                               name="start"
                                               value="<?= isset($tart) ? $tart : '' ?>"
                                        />
                                    </div>
                                </div>
                                <div class="form-group hiddenField">
                                    <label for="end">Date de fin</label>
                                    <div class='input-group datetimepicker'>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                        </span>
                                        <input type='text'
                                               class="form-control"
                                               id="end"
                                               name="end"
                                               value="<?= isset($end) ? $end : '' ?>"
                                        />
                                    </div>
                                </div>

                                <?php if (!empty($teacherInfo)): ?>
                                    <div class="form-group hiddenField">
                                        <label for="teacher">Enseignant</label>
                                        <select class="form-control required" id="teacher" name="teacher">
                                            <option value="<?= $teacherInfo->id ?>" selected=selected>
                                                <?= $teacherInfo->name ?>
                                            </option>
                                        </select>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($rooms)): ?>
                                    <div class="form-group hiddenField">
                                        <label for="room">Salles</label>
                                        <select class="form-control required" id="room" name="room">
                                            <option value="">Sélectionnez une salle</option>
                                            <?php foreach ($rooms as $room): ?>
                                                <option value="<?= $room->id ?>"
                                                        title="<?= $room->description ?>"
                                                    <?php if (isset($roomId) && $room->id == $roomId) {
                                                        echo 'selected=selected';
                                                    } ?>
                                                >
                                                    <?= $room->name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <hr>
                                <div class="input-group-btn hiddenField">
                                    <button id="add-new-event" type="button" class="btn btn-primary btn-flat">
                                        Ajouter
                                    </button>
                                </div>
                            <?php endif; ?>
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
    var $allocations = <?= $allocations ?>;
    var $lessonsAreEmpty = <?= $lessonsAreEmpty ? '1' : '0' ?>;
    var $levelIdIsSet = <?= $levelIdIsSet ? '1' : '0' ?>;
</script>
<script>
    // TODO: https://fullcalendar.io/docs/event-dragging-resizing
    // TODO: When drag stops => update the events
    // TODO: When resize stops => update the events
    $(function () {

        if ($lessonsAreEmpty && $levelIdIsSet) {
            alert("/!\\ Aucune unité d'enseignement n'a été trouvée pour cette filière. Veuillez contacter l'administrateur");
            // $('.hiddenField').addClass('display-none');
        }

        /** DATETIME PICKER **/
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD H:m',
            locale: 'fr'
        });

        /** THE CALENDAR **/

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'Aujourd\'hui',
                month: 'Mois',
                week: 'Semaine',
                day: 'Jours'
            },
            events: $allocations,
            editable: true,
            eventRender: function (event, element) {
                element.find(".fc-title").remove();
                element.find(".fc-time").remove();
                let new_description =
                    moment(event.start).format("HH:mm") + '-'
                    + moment(event.end).format("HH:mm") + '<br/>'
                    + '<strong>Title: </strong>' + event.title + '<br/>'
                    + '<strong>Teacher: </strong>' + event.teacherName + '<br/>'
                    + '<strong>Class: </strong>' + event.levelName + '<br/>';
                element.append(new_description);
            }
        });

        /** ADD SELECTED COLOR TO THE ADD BUTTON **/

        let currColor = '#3c8dbc';

        $('#color-chooser > li > a').click(function (e) {
            e.preventDefault();
            currColor = $(this).css('color');
            $('#add-new-event').css({'background-color': currColor, 'border-color': currColor})
        });

        /** ADD NEW ALLOCATION TO THE CALENDAR **/

        $('#add-new-event').click(function (e) {
            e.preventDefault();

            let resourceId = $('#room').val();
            let resourceName = $('#room option:selected').text();
            let teacherId = $('#teacher').val();
            let teacherName = $('#teacher option:selected').text();
            let levelId = $('#level').val();
            let levelName = $('#level option:selected').text();

            // TODO: Vérifier que les champs obligatoires sont remplis

            if (resourceName.length == 0) {
                return
            }

            let start = $('#start').val();
            let end = $('#end').val();
            let $url = "<?= base_url() ?>add_allocation";
            let originalEventObject = {};

            originalEventObject.rowStart = start;
            originalEventObject.rowEnd = end;
            originalEventObject.start = new Date(start);
            originalEventObject.end = new Date(end);
            originalEventObject.title = resourceName;
            originalEventObject.resourceId = resourceId;
            originalEventObject.allDay = false;
            originalEventObject.backgroundColor = $(this).css('background-color');
            originalEventObject.borderColor = $(this).css('border-color');
            originalEventObject.levelName = levelName.trim();
            originalEventObject.levelId = levelId;
            originalEventObject.teacherName = teacherName.trim();
            originalEventObject.teacherId = teacherId;

            updateEvents($url, originalEventObject);

        });


        $(".searchForm").change(function () {
            $('#search').submit();
        });

        /** SELECTED RESOURCE TYPE LOADS THE CORRESPONDING RESOURCES **/

        //$("#resource-type").change(function () {
        //
        //    let resourceTypeId = $(this).val();
        //
        //    if (resourceTypeId == 0) {
        //        $(".hiddenField").addClass('display-none');
        //        $("#field-teacher").addClass('display-none');
        //        return;
        //    }
        //
        //    $(".hiddenField").removeClass('display-none');
        //
        //    $.ajax({
        //        url: "<?//= base_url() ?>//allocation_data/" + resourceTypeId,
        //        method: "GET",
        //        dataType: 'json'
        //    })
        //        .done(function (data) {
        //            $("#resource").empty()
        //                .prepend("<option value=''>Sélectionnez la ressource</option>").val('');
        //            $.each(data.resources, function (index, resource) {
        //                $("#resource").append($("<option>", {
        //                    value: resource.id,
        //                    text: resource.name
        //                }));
        //            });
        //        })
        //        .fail(function (xhr) {
        //            //  TODO: afficher le message de confirmation dans une div alert error
        //            console.log('error callback 2', xhr);
        //        });
        //});

    });

    /** ADD NEW ALLOCATION TO THE CALENDAR AND SAVE IT TO THE DATABASE **/

    function updateEvents($url, $calendarObject) {

        $.ajax({
            url: $url,
            method: "POST",
            data: {
                resource: $calendarObject.resourceId,
                start: $calendarObject.rowStart,
                end: $calendarObject.rowEnd,
                allDay: $calendarObject.allDay,
                backgroundColor: $calendarObject.backgroundColor,
                borderColor: $calendarObject.borderColor,
                level: $calendarObject.levelId,
                teacher: $calendarObject.teacherId

            }
        })
            .done(function (data) {
                //  TODO: afficher le message de confirmation dans une div alert success
                console.log('success callback 1', data);
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', $calendarObject, true);
            })
            .fail(function (xhr) {
                //  TODO: afficher le message de confirmation dans une div alert error
                console.log('error callback 2', xhr);
            });
    }
</script>