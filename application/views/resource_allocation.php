<div class="content-wrapper">
    <section class="content-header">
        <div class="row">
            <div class="col-md-3">
                <h3 class="text-primary text-bold">
                    Affectation des ressources
                    <small>IN430</small>
                </h3>
            </div>
            <div class="col-md-9">
                <form name="search" id="search" action="<?= base_url()?>resource_allocation" method="post">
                    <div class="form-group">
                        <label for="filiere">Choisir la classe à visualiser</label>
                        <select name="filiere" id="filiere" class="form-control">
                            <option value="">Sélectionnez la filière</option>
                            <?php foreach ($levels as $level): ?>
                                <option value="<?= $level->id ?>" <?php if (isset($levelId) && $level->id == $levelId) {
                                    echo 'selected=selected';
                                } ?>>
                                    <?= $level->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">

                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-yellow text-bold">Effectuer une affectation</h3>
                            </div>
                        </div>

                        <hr>

                        <!-- SELECT CLASS CALENDAR -->
                        <form id="search" name="search" method="post" action="<?= base_url() ?>resource_allocation">

                            <div class="form-group">
                                <label for="color">Etiquettes</label>
                                <select name="color" class="form-control" id="color">
                                    <option value="">Choisir une étiquette</option>
                                    <?php foreach ($colors as $label => $colorValue): ?>
                                        <option style="color:<?= $colorValue ?>;"
                                                value="<?= $colorValue ?>"
                                            <?= isset($color) && $color == $colorValue ? 'selected=selected' : '' ?>
                                        ><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group ">
                                <label for="level">Niveau d'études</label>
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

                            <div class="form-group hiddenField lesson">
                                <label for="lesson">Unité d'enseignement</label>
                                <select class="form-control searchForm required" id="lesson" name="lesson"></select>
                            </div>

                            <div class="form-group hiddenField dates">
                                <label for="start">Date de début</label>
                                <div class='input-group datetimepicker'>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar text-primary"></span>
                                    </span>
                                    <input type='text' class="form-control" id="start" name="start" />
                                </div>
                            </div>

                            <div class="form-group hiddenField dates">
                                <label for="end">Date de fin</label>
                                <div class='input-group datetimepicker'>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar text-primary"></span>
                                    </span>
                                    <input type='text' class="form-control" id="end" name="end" />
                                </div>
                            </div>

                            <div class="form-group hiddenField teacher">
                                <label for="teacher">Enseignant</label>
                                <select class="form-control required" id="teacher" name="teacher"></select>
                            </div>

                            <div class="form-group hiddenField room">
                                <label for="room">Salles</label>
                                <select class="form-control required" id="room" name="room"></select>
                            </div>

                            <hr>

                            <div class="input-group-btn hiddenField submitBtn">
                                <button id="add-new-event" type="button" class="btn btn-primary btn-flat">
                                    Ajouter
                                </button>
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
    var $allocations = <?= $allocations ?>;
    var baseUrl = '<?= base_url(); ?>';
    var $levelId = '<?= isset($levelId) ? $levelId : 0; ?>';
</script>
<script>
    $(function () {

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
            eventLimit: true,
            selectable: true,
            selectHelper: true,
            select: function (start, end) {
                $('#start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
            },
            eventRender: function (event, element) {
                element.find(".fc-title").remove();
                element.find(".fc-time").remove();
                let eventDetail =
                    moment(event.start).format("HH:mm") + '-'
                    + moment(event.end).format("HH:mm") + '<br/>'
                    + '<strong>' + event.title + '</strong><br/>'
                    + '<i>' + event.teacherName + '</i><br/>'
                    + '<i>' + event.levelName + '</i><br/>'
                    + '<i>' + event.lessonName + '</i><br/>'
                ;
                element.append(eventDetail);
            },
            eventClick: function(calEvent, jsEvent, view) {
                swal.fire({
                    title: '<strong><i>Que voulez-vous réaliser comme action ?</i></strong>',
                    type: 'info',
                    html: '<span class="text-danger">Cliquez sur bouton rouge pour supprimer</span> <b>ET</b> ' +
                        '<span class="text-success">sur le bouton vert pour éditer</span>',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText:'Supprimer',
                    confirmButtonColor: '#d62522',
                    cancelButtonText: 'Editer',
                    cancelButtonColor: '#2b803a',
                    preConfirm: function (e) {
                        let $url = "<?= base_url() ?>delete_allocation/" + calEvent.eventId;
                        deleteEvent($url, calEvent)
                    }
                }).then((result) => {
                    if (result.value) {
                        $('#calendar').fullCalendar('removeEvents', calEvent._id);
                        Swal.fire(
                            'Supprimé!',
                            'Affectation enlevée du calendrier.',
                            'success'
                        )
                    } else {
                        console.log('cancel'); // TODO: mettre la requête ajax qui va récupérer les évènements correspondants à l'id de l'évènement sélectionné
                    }
                });
            },
        });

        /** ADD SELECTED COLOR TO THE ADD BUTTON **/

        let defaultColor = '#3c8dbc';

        $('#color').change(function (e) {
            e.preventDefault();
            let color = $(this).val();
            if (!color) {
                color = defaultColor;
            }
            $('#add-new-event').css({'background-color': color, 'border-color': color})
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
            let lessonId = $('#lesson').val();
            let lessonName = $('#lesson option:selected').text();

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
            originalEventObject.lessonName = lessonName.trim();
            originalEventObject.lessonId = lessonId;

            addEvents($url, originalEventObject);

        });

        /**
         * LOAD THE CALENDAR WE WANT TO SEE WHEN CHOOSING STUDY LEVEL AT THE TOP OF THE PAGE and
         * ACTIVATES SOME FIELDS NEEDED TO CREATE EVENTS
         */
        if ($levelId) {
            activateLessonsField($levelId);
        }

        $("#level").change(function () {
            let $level = $(this).val();
            activateLessonsField($level);
        });

        $("#lesson").change(function () {
            let $lesson = $(this).val();
            let $classes = ['.teacher', '.dates', '.submitBtn', '.room'];

            buildSelectOptions(
                getUrl($lesson, 'load_user_ajax'),
                $('#teacher'),
                $classes,
                $lesson
            );

            buildSelectOptions(
                getUrl($lesson, 'load_rooms_ajax'),
                $('#room'),
                [],
                $lesson
            );
        });

        /** FETCHES THE CALENDAR BASE ON STUDY LEVEL **/
        $("#filiere").change(function () {
            $('#search').submit();
        });

    });

    /** ADD NEW ALLOCATION TO THE CALENDAR AND SAVE IT TO THE DATABASE **/
    function addEvents($url, $calendarObject) {

        $.ajax({
            url: $url,
            method: "POST",
            dataType: 'json',
            data: {
                resource: $calendarObject.resourceId,
                start: $calendarObject.rowStart,
                end: $calendarObject.rowEnd,
                allDay: $calendarObject.allDay,
                backgroundColor: $calendarObject.backgroundColor,
                borderColor: $calendarObject.borderColor,
                level: $calendarObject.levelId,
                lesson: $calendarObject.lessonId,
                teacher: $calendarObject.teacherId
            }
        })
        .done(function (data) {
            $calendarObject.eventId = data.eventId;
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', $calendarObject, true);
        })
        .fail(function (xhr) {
            fireDialog('error', 'Erreur', xhr.responseText);
        });
    }

    /** DELETE ALLOCATION FROM THE CALENDAR AND FROM THE DATABASE **/
    function deleteEvent($url, $calEvent) {
        $.ajax({
            url: $url,
            method: "POST",
            dataType: 'json',
            data: {
                event: $calEvent.eventId
            }
        });
    }

    /**
     * Clear all the hidden select and hides the divs that contain them => if option is null
     * Show all fields => if option is not null
     * @param $classes
     * @param $value
     * @param $dataFound
     */
    function showHideFields($classes, $value, $dataFound) {
        if ($classes && ($value == 0 || !$dataFound)) {
            $.each( $classes, function( index, $class ){
                $($class).each(function () {
                    $(this).addClass('hiddenField');
                    $(this).find('select').empty();
                });
            });
            return;
        }

        $.each( $classes, function( index, $class ){
            $($class).each(function () {
                $(this).removeClass('hiddenField');
            });
        });
    }

    /**
     * Build and return the url used to get data
     * @param $id
     * @param $uri
     * @returns {string}
     */
    function getUrl($id, $uri) {
        return baseUrl + $uri + '/' + $id;
    }

    /**
     *
     * @param $url
     * @param $select
     * @param $classes
     * @param $valueToCheck
     */
    function buildSelectOptions($url, $select, $classes, $valueToCheck) {

        $.ajax({
            url: $url,
            method: "POST",
            dataType: 'json'
        })
        .done(function (data) {

            $select.empty();

            if (data.placeholder) {
                $select.append('<option value="0">' + data.placeholder + '</option>');
            }

            showHideFields($classes, $valueToCheck, data.json);

            if (data.json) {
                $.each(data.json, function (index, table) {
                    $select.append($("<option></option>").attr("value", table.id).text(table.name));
                });
            }
        })
        .fail(function (xhr) {
            // Error dialog shows only if no data found and user have selected a value
            if ($valueToCheck != 0) {
                fireDialog('info', 'Information', xhr.responseText);
            }

            showHideFields($classes, $valueToCheck, false);
        });
    }

    function fireDialog($type, $title, $msg) {
        Swal.fire({
            type: $type,
            title: $title,
            html: '<h4 class="text-danger text-center">'+$msg+'</h4>',
        });
    }

    function activateLessonsField($level) {
        let $classes = ['.lesson', '.teacher', '.dates', '.submitBtn', '.room'];

        buildSelectOptions(
            getUrl($level, 'load_lesson_ajax'),
            $('#lesson'),
            $classes,
            $level
        );
    }
</script>