<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Room_model extends CI_Model
{
    private $event = 'resource_allocation';

    private $room = 'resources';

    /**
     * @return CI_DB_query_builder
     */
    private function getBaseQuery(): CI_DB_query_builder
    {
        $this->db->select("
            r.id, 
            r.label as name, 
            r.description
        ");
        $this->db->from("$this->room as r");
        $this->db->join('categories as cat','cat.id = r.categoryId');
        return $this->db->where("cat.label", "SALLES");
    }

    /**
     * This function is used to get lessons rooms
     */
    function getRooms(): ?array
    {
        $qb = $this->getBaseQuery();
        return $qb->get()->result();
    }

    /**
     * @param array $datesToCheck
     * @param int $semester
     * @return array|null
     */
    public function getAvailableRoomsForSemester(array $datesToCheck, int $semester): ?array
    {
        $unavailableRooms = $this->getUnavailableRoomsFormSemester($datesToCheck, $semester);

        $roomIds = [];
        array_walk_recursive($unavailableRooms, function($resource) use (&$roomIds) { $roomIds[] = $resource; });

        $qb = $this->getBaseQuery();

        if (count($roomIds) > 0) {
            $qb->where_not_in("r.id", $roomIds);
        }

        return $qb->get()->result();
    }


    /**
     * @param array $datesToCheck
     * @param int $semester
     * @return array|null
     */
    public function getUnavailableRoomsFormSemester(array $datesToCheck, int $semester): ?array
    {
        $where_period = '';
        $this->db->select("ra.resource_id");
        $this->db->distinct();
        $this->db->from("$this->event as ra");

        $len = count($datesToCheck);

        foreach ($datesToCheck as $index => $date) {
            $min = $date['start'];
            $max = $date['end'];

            $true = $index < $len - 1;

            $where_period .= "(ra.start_date < '{$min}' AND '{$min}' < ra.end_date) OR ";
            $where_period .= "('{$min}' < ra.start_date AND ra.start_date < '{$max}') OR ";
            $where_period .=  "('{$min}' < ra.end_date AND ra.end_date < '{$max}')" . ($true ? " OR " : "");

        }
        $this->db->where($where_period);
        $this->db->where('ra.semester_id', $semester);
        return $this->db->get()->result_array();
    }
}

