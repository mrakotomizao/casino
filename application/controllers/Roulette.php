<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roulette extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(TRUE);
    }

    public function index()
    {
        $this->load->model('action');
        $this->load->model('utilisateur', 'user');

        $user = (object)$this->facebook->api('/me');

        $fbid = $user->id;
        $nom = $user->last_name;
        $prenom = $user->first_name;
        $pseudo = $user->name;
        $email = $user->email;
        $newsletter = $this->input->post('newsletter');

        $this->user->setUtilisateur($fbid, $nom, $prenom, $pseudo, $email, $newsletter);

        $total = $this->action->getSumVal($fbid);
        $total = isset($total[0]->valeur) ? (empty($total[0]->valeur) ? $total[0]->valeur : 0) : 0;

        $currentRanking = $this->getRanking($total[0]->valeur);

        /*
         * ON RECUPERE LA DIFFERENCE ENTRE LE PALIER MIN ET NOTRE VALUE TOTAL
         * ELLE PERMETTRA DE DEFINIR L'AVANCEMENT
         */
        $diff = abs($total[0]->valeur - $currentRanking->min);
        $max = abs($currentRanking->max - $currentRanking->min);
        $nbaction = 3 - $this->getNbAction($fbid);
        $resultDaily = $this->getDailyPoint($fbid);

        $dailyTotal = empty($resultDaily[0]->valeur) ? 0 : $resultDaily[0]->valeur;
        $data = [
            'fbId' => $fbid,
            'diff' => $diff,
            'rank' => $currentRanking,
            'max' => $max,
            'total' => empty($total[0]->valeur) ? 0 : $total[0]->valeur,
            'nbaction' => $nbaction,
            'dailyTotal' => $dailyTotal
        ];

        $this->load->view('roulette', $data);
    }

    public function getRanking($val = null)
    {
        $total = empty($val) ? $this->input->post('total') : $val;
        $this->load->model('rang', 'rank');

        $allRank = $this->rank->getAll();
        if (isset($allRank)) {
            if (empty($total)) {
                $currentRanking = $allRank[0];
            } else {
                foreach ($allRank as $rank) {
                    if ($total > 3000) {
                        $currentRanking = $allRank[3];
                    } else {
                        if ($total >= $rank->min && $total < $rank->max) {
                            $currentRanking = $rank;
                        }
                    }
                }
            }
        }
        if (!$this->input->is_ajax_request()) {
            return $currentRanking;
        } else {
            echo json_encode($currentRanking);
        }

    }

    public function setPoint()
    {
        $iduser = $this->input->post('iduser');
        $value = $this->input->post('value');

        if ($this->getNbAction($iduser) < 3) {
            $this->load->model('action', 'action');

            $this->action->setAction($iduser, $value);

            echo json_encode("done");
        } else {
            echo json_encode(['error' => 'Vous n\'avez plus de quota d\'action']);
        }
    }

    public function ajaxGetNbAction()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('action', 'action');

            $fbid = $this->input->post('fbid');

            echo json_encode($this->action->getDailyAction($fbid));
        } else {
            exit('No direct script access allowed');
        }
    }

    private function getNbAction($iduser)
    {
        $this->load->model('action', 'action');

        return $this->action->getDailyAction($iduser);
    }

    public function getDailyPoint($iduser = null)
    {
        $this->load->model('action', 'action');
        $fbid = empty($iduser) ? $this->input->post('fbid') : $iduser;

        if ($this->input->is_ajax_request()) {
            echo json_encode($this->action->getDailyPoint($fbid));
        } else {
            return $this->action->getDailyPoint($iduser);
        }
    }
}
