<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'base/BaseController.php';

class Fake extends BaseController
{
    /**
     * @var \Faker\Generator $faker
     */
    private $faker;

    function __construct()
    {
        parent::__construct();
        $this->faker = Faker\Factory::create();
        $this->load->model('user_model');
        $this->load->model('resource_model');
    }

    /**
     * seed local database
     */
    function seedUser()
    {
        $this->_truncate_user_db();
        $this->_seed_users(25);
    }


    /**
     * seed local database
     */
    function seedResource()
    {
        $this->_truncate_resource_db();
        $this->_seed_resources(20);
    }

    /**
     * seed local database
     */
    function seedCategory()
    {
        $this->_truncate_category_db();
        $this->_seed_categories();
    }

    /**
     * seed users
     *
     * @param int $limit
     */
    function _seed_users($limit)
    {

        /** ADMIN */
        $data = [
            'email' => 'dmla@projet430.com ',
            'password' => getHashedPassword('password'),
            'name' => 'Lin D',
            'serial_number' => null,
            'mobile' => $this->faker->phoneNumber,
            'roleId' => 1,
            'isDeleted' => false,
            'status' => 1,
            'createdBy' => 1,
            'createdDtm' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
            'updatedBy' => 1,
            'updatedDtm' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s')
        ];
        $this->user_model->add($data);


        /** STUDENTS */
        for ($i = 0; $i < $limit; $i++) {
            $matricule = substr(strtoupper($this->faker->word) . $this->faker->dateTimeThisCentury->format('His'), 0, 19);
            $data = [
                'email' => $this->faker->email,
                'password' => getHashedPassword('password'),
                'name' => $this->faker->unique()->name,
                'serial_number' => $matricule,
                'mobile' => $this->faker->phoneNumber,
                'roleId' => 2,
                'isDeleted' => false,
                'status' => 0,
                'createdBy' => 1,
                'createdDtm' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
                'updatedBy' => 1,
                'updatedDtm' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s')
            ];
            $this->user_model->add($data);
        }

        /** TEACHERS */
        for ($i = 0; $i < ($limit-15); $i++) {
            $matricule = substr(strtoupper($this->faker->word) . $this->faker->dateTimeThisCentury->format('His'), 0, 19);
            $data = [
                'email' => $this->faker->email,
                'password' => getHashedPassword('password'),
                'name' => $this->faker->unique()->name,
                'serial_number' => $matricule,
                'mobile' => $this->faker->phoneNumber,
                'roleId' => 3,
                'isDeleted' => false,
                'status' => 0,
                'createdBy' => 1,
                'createdDtm' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
                'updatedBy' => 1,
                'updatedDtm' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s')
            ];
            $this->user_model->add($data);
        }

        $this->session->set_flashdata('success', 'Database Successfully Seeded 26 users added in the database');

        redirect('dashboard');
    }

    function _seed_resources(int $limit)
    {
        /** RESSOURCES TYPE SALLE */
        for ($i = 0; $i < $limit; $i++) {
            $data = [
                'label' => 'SALLE 10'.($i + 1),
                'description' => $this->faker->word(),
                'categoryId' => 1,
                'createdBy' => 1,
                'created' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s')
            ];
            $this->resource_model->add($data);
        }

        /** RESSOURCES TYPE APPAREIL */
        for ($i = 0; $i < ($limit-10); $i++) {
            $data = [
                'label' => 'APPAREIL MV'.($i + 1),
                'description' => $this->faker->word(),
                'categoryId' => 2,
                'createdBy' => 1,
                'created' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s')
            ];
            $this->resource_model->add($data);
        }

        /** RESSOURCES TYPE COURS */
        for ($i = 0; $i < ($limit-10); $i++) {
            $data = [
                'label' => 'COURS'.($i + 1),
                'description' => $this->faker->word(),
                'categoryId' => 3,
                'createdBy' => 1,
                'created' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s')
            ];
            $this->resource_model->add($data);
        }

        $this->session->set_flashdata('success', 'Database Successfully Seeded 25 resources added in the database');

        redirect('dashboard');
    }

    function _seed_categories()
    {
        $categories = [
            [
                'label' => 'SALLES'
            ],
            [
                'label' => 'APPAREILS'
            ],
            [
                'label' => 'COURS'
            ]
        ];

        foreach ($categories as $category) {
            $this->resource_model->addCategory($category);
        }

        $this->session->set_flashdata('success', 'Database Successfully Seeded 4 categories added in the database');

        redirect('dashboard');
    }

    private function _truncate_user_db()
    {
        $this->user_model->truncate();
    }

    private function _truncate_resource_db()
    {
        $this->resource_model->truncate();
    }

    private function _truncate_category_db()
    {
        $this->resource_model->truncateCategory();
    }
}
