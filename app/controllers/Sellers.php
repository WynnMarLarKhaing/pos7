<?php
class Sellers extends Controller
{
    public function __construct()
    {
        // if (!isLoggedIn()) {
        //     redirect('/users/login');
        // }

        $this->customerModel = $this->model('Seller');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $customers = $this->customerModel->getCustomers();

        $data = [
            'customers' => $customers
        ];
        $this->view('sellers/index', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'name_zawgyi' => trim($_POST['name_zawgyi']),
                'phone'  => trim($_POST['phone']),
                'name_err' => '',
                'phone_err'  => '',
                'address'  => trim($_POST['address']),
            ];

            //Validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            //Validate phone
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter phone text';
            }

            //Validated
            if (empty($data['name_err']) && empty($data['phone_err'])) {
                if ($this->customerModel->addPost($data)) {
                    flash('post_message', 'Post Added');
                    redirect('sellers');
                } else {
                    die("Something went wrong!");
                }
            } else {
                //Load view with errors
                $this->view('sellers/add', $data);
            }
        } else {

            $data = [
                'name' => '',
                'name_zawgyi' => '',
                'phone'  => '',
                'address'  => '',
            ];
        }

        $this->view('sellers/add', $data);
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id'        => $id,
                'name'     => trim($_POST['name']),
                'name_zawgyi'     => trim($_POST['name_zawgyi']),
                'phone'      => trim($_POST['phone']),
                'name_err' => '',
                'phone_err'  => '',
                'address'  => trim($_POST['address']),
            ];

            //Validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            //Validate phone
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter phone text';
            }

            //Validated
            if (empty($data['name_err']) && empty($data['phone_err'])) {
                if ($this->customerModel->updatePost($data)) {
                    flash('post_message', 'Post updated');
                    redirect('sellers');
                } else {
                    die("Something went wrong!");
                }
            } else {
                //Load view with errors
                $this->view('sellers/edit', $data);
            }
        } else {

            //Get existing post from model
            $post = $this->customerModel->getPostById($id);

            $data = [
                'id'    => $id,
                'name' => trim($post->name),
                'name_zawgyi' => trim($post->name_zawgyi),
                'phone'  => trim($post->phone),
                'address'  => trim($post->address),
            ];
        }
        $this->view('sellers/edit', $data);
    }

    public function show($id)
    {
        $customer = $this->customerModel->getPostById($id);
        // $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'customer' => $customer,
        ];
        $this->view('sellers/show', $data);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->customerModel->deletePost($id)) {
                flash('post_message', 'Post deleted');
                redirect('sellers');
            } else {
                die("Something went wrong");
            }
        } else {
            redirect('sellers');
        }
    }

    public function clear()
    {
        $this->customerModel->clearPost();
        redirect('sellers');
    }

    public function download($id)
    {
        printPdf1();
    }
}
