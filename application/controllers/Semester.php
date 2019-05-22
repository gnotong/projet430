<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'base/BaseController.php';

/**
 * Class : Semester (SemesterController)
 */
class Semester extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->datas();

        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            redirect('login');
        } else {
            if (!$this->isAdmin()) {
                $this->accesslogincontrol();
            }
        }
    }

    /**
     * This function used to show resources
     */
    public function list()
    {
        $data['semesters'] = $this->semester_model->getAll();
        $this->global['pageTitle'] = 'UY1: Semestres';

        $this->loadViews("semester/list", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new resource
     */
    private function newSemesterForm()
    {
        $this->global['pageTitle'] = 'UY1: Ajouter un semestre';

        $this->loadViews("semester/form_add_edit_semester", $this->global, NULL, NULL);
    }

    public function add()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Nom', 'required');
        $this->form_validation->set_rules('year', 'Année', 'required');
        $this->form_validation->set_rules('start', 'Date de début', 'required');
        $this->form_validation->set_rules('end', 'Date de fin', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->newSemesterForm();
        } else {
            $semester = [
                'name' => $this->input->post('name'),
                'year' => $this->input->post('year'),
                'start' => $this->input->post('start'),
                'end' => $this->input->post('end')
            ];

            $lessonId = $this->semester_model->add('semesters', $semester);

            if ($lessonId > 0) {
                $process = 'Ajouter un semestre';
                $processFunction = 'Semester/add';
                $this->log($process, $processFunction);

                $this->session->set_flashdata('success', 'Semestre créée avec succès');
            } else {
                $this->session->set_flashdata('error', "La création du semestre a échouée !!");
            }

            redirect('add_semester');
        }
    }

    /**
     * @param int $semesterId
     */
    private function editSemesterForm(int $semesterId)
    {
        $data['semester'] = $this->semester_model->getById($semesterId);

        $this->global['pageTitle'] = 'UY1 : Modifier le semestre';

        $this->loadViews("semester/form_add_edit_semester", $this->global, $data, NULL);
    }

    /**
     * @param int|null $semesterId
     */
    public function edit(int $semesterId = NULL): void
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Nom', 'required');
        $this->form_validation->set_rules('year', 'Année', 'required');
        $this->form_validation->set_rules('start', 'Date de début', 'required');
        $this->form_validation->set_rules('end', 'Date de fin', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->editSemesterForm($semesterId);
        } else {

            $semester = [
                'name' => $this->input->post('name'),
                'year' => $this->input->post('year'),
                'start' => $this->input->post('start'),
                'end' => $this->input->post('end')
            ];

            $updated = $this->lesson_model->update('semesters', $semester, 'id', $semesterId);

            if ($updated) {
                $process = 'Edition d\'un semestre';
                $processFunction = 'Semester/edit';
                $this->log($process, $processFunction);
                $this->session->set_flashdata('success', 'Semestre modifiée avec succès');
            } else {
                $this->session->set_flashdata('error', 'La modification du semestre a échoué');
            }
            redirect('semesters');

        }
    }

    /**
     * @param int|null $semesterId
     */
    public function delete(int $semesterId = NULL): void
    {
        if ($semesterId == null) {
            redirect('semesters');
        }

        $deleted = $this->semester_model->delete('semesters', 'id', $semesterId);

        if ($deleted) {
            $process = 'Suprpession de semestre';
            $processFunction = 'Semester/delete';
            $this->log($process, $processFunction);

            $this->session->set_flashdata('success', 'Semestre supprimées avec succès');
        } else {
            $this->session->set_flashdata('error', 'Erreur de suppression du semestre');
        }
        redirect('semesters');
    }

    /**
     * @param int $semesterId
     */
    public function getSemesterDatesAjax(int $semesterId)
    {
        $semester = null;
        if ($semesterId) {
            $semester = $this->semester_model->getById($semesterId);
        }

        try {
            if ($semester) {
                echo json_encode(array('success' => 1, 'json' => $semester, 'placeholder' => 'Sélectionnez l\'unité d\'enseignement'));
            } else {
                throw new \Exception('Le niveau d\'étude que vous avez sélectionné n\'a pas de cours enregistrés pour le moment. <br><br>Veuillez contacter votre administrateur.');
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function getSemestersAjax()
    {
        echo json_encode(array('success' => 1, 'json' => $this->semester_model->getAll(), 'placeholder' => 'Sélectionnez le semestre'));
    }

}