<?php
class ControllerExtensionModuleOccolorswatches extends Controller 
{
    public function install() {
        $this->load->model('extension/module/occolorswatches');

        $this->model_extension_module_occolorswatches->installSwatchesAttribute();
    }

    public function uninstall() {
        $this->load->model('extension/module/occolorswatches');
    }

    public function index() {
        $this->load->language('extension/module/occolorswatches');

        $this->document->setTitle($this->language->get('page_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_occolorswatches', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['width'])) {
            $data['error_width'] = $this->error['width'];
        } else {
            $data['error_width'] = '';
        }

        if (isset($this->error['height'])) {
            $data['error_height'] = $this->error['height'];
        } else {
            $data['error_height'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/occolorswatches', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/occolorswatches', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->post['module_occolorswatches_status'])) {
            $data['module_occolorswatches_status'] = $this->request->post['module_occolorswatches_status'];
        } else {
            $data['module_occolorswatches_status'] = $this->config->get('module_occolorswatches_status');
        }

        if (isset($this->request->post['module_occolorswatches_width'])) {
            $data['module_occolorswatches_width'] = $this->request->post['module_occolorswatches_width'];
        } else {
            $data['module_occolorswatches_width'] = $this->config->get('module_occolorswatches_width');
        }

        if (isset($this->request->post['module_occolorswatches_height'])) {
            $data['module_occolorswatches_height'] = $this->request->post['module_occolorswatches_height'];
        } else {
            $data['module_occolorswatches_height'] = $this->config->get('module_occolorswatches_height');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/occolorswatches', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/occolorswatches')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['module_occolorswatches_width']) {
            $this->error['width'] = $this->language->get('error_width');
        }

        if (!$this->request->post['module_occolorswatches_height']) {
            $this->error['height'] = $this->language->get('error_height');
        }

        return !$this->error;
    }
}