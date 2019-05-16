<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require 'base/BaseController.php';

/**
 * Class : Level (LevelController)
 */
class Level extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This function used to show resources
     */
    public function list()
    {
        $data['levels'] = $this->level_model->getAll();
        $this->global['pageTitle'] = 'UY1: Niveaux d\'études';

        $this->loadViews("level/list", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new resource
     */
    private function newLevelForm()
    {
        $this->global['pageTitle'] = 'UY1: Ajouter un cours';

        $this->loadViews("level/form_add_level", $this->global, null, NULL);
    }

    /**
     * This function is used to add new resource to the system
     */
    public function add()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Nom', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->newLevelForm();
        } else {
            $name = $this->input->post('name');

            $levelId = $this->level_model->add(['name' => $name]);

            if ($levelId > 0) {
                $process = 'Ajouter un niveau d\'études';
                $processFunction = 'Level/add';
                $this->log($process, $processFunction);

                $this->session->set_flashdata('success', 'Niveau d\'études créée avec succès');
            } else {
                $this->session->set_flashdata('error', "La niveau d'études $name a échouée !!");
            }

            redirect('add_level');
        }
    }

    /**
     * @param int $levelId
     */
    private function editLevelForm(int $levelId)
    {
        $data['level'] = $this->level_model->getLevelById($levelId);

        $this->global['pageTitle'] = 'UY1 : Modifier la resource';

        $this->loadViews("level/form_edit_level", $this->global, $data, NULL);
    }

    /**
     * This function is used to edit resource
     * @param int $levelId
     */
    public function edit(int $levelId = NULL): void
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Nom', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->editLevelForm($levelId);
        } else {

            $name = $this->input->post('name');
            $levelId = $this->input->post('levelId');

            $updated = $this->level_model->update(['name' => $name], $levelId);

            if ($updated) {
                $process = 'Edition d\'un niveai d\'études';
                $processFunction = 'Level/edit';
                $this->log($process, $processFunction);
                $this->session->set_flashdata('success', 'Niveau d\'études modifiée avec succès');
            } else {
                $this->session->set_flashdata('error', 'La modification niveau d\'études a échoué');
            }
            redirect('levels');
        }
    }

    /**
     * @param int $levelId
     */
    public function delete(int $levelId = NULL): void
    {
        if ($levelId == null) {
            redirect('levels');
        }

        $deleted = $this->level_model->delete($levelId);

        if ($deleted) {
            $process = 'Suprpession du niveau d\'études';
            $processFunction = 'Level/delete';
            $this->log($process, $processFunction);

            $this->session->set_flashdata('success', 'Niveau d\'études supprimée avec succès');
        } else {
            $this->session->set_flashdata('error', 'Erreur de suppression du Niveau d\'études ');
        }
        redirect('levels');
    }

}