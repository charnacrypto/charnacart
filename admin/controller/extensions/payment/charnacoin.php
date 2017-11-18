<?php
class ControllerExtensionPaymentCharnacoin extends Controller
{
    private $error = array();
    private $settings = array();
    public function index()
    {
        $this->load->language('extension/payment/charnacoin');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_setting_setting->editSetting('charnacoin', $this->request->post);
            $this->session->data['success'] = "Success! Welcome to Charnacoin!";
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
        }
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_edit'] = $this->language->get('text_edit');
        
        
        $data['charnacoin_address_text'] = $this->language->get('charnacoin_address_text');
        $data['button_save'] = "save";
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['help_total'] = $this->language->get('help_total');
        //Errors
        $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        
        
       
       // Values for Settings
        $data['charnacoin_address'] = isset($this->request->post['charnacoin_address']) ?
            $this->request->post['charnacoin_address'] : $this->config->get('charnacoin_address');
         $data['charnacoin_status'] = isset($this->request->post['charnacoin_status']) ?
            $this->request->post['charnacoin_status'] : $this->config->get('charnacoin_status');

       
       
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/charnacoin', 'token=' . $this->session->data['token'], true)
        );
        $data['action'] = $this->url->link('extension/payment/charnacoin', 'token=' . $this->session->data['token'], true);
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('extension/payment/charnacoin.tpl', $data));
    } //index
    //validate
    private function validate()
    {
        //permisions
        if (!$this->user->hasPermission('modify', 'extension/payment/charnacoin')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return true;
       
    }
    public function install()
    {
        $this->load->model('extension/payment/charnacoin');
        $this->load->model('setting/setting');
        
        $this->model_setting_setting->editSetting('charnacoin', $this->settings);
        $this->model_extension_payment_charnacoin->createDatabaseTables();
    }
    public function uninstall()
    {
        $this->load->model('extension/payment/charnacoin');
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('charnacoin');
        $this->model_extension_payment_charnacoin->dropDatabaseTables();
    }
}
