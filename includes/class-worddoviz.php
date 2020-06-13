<?php
use Teknomavi\Tcmb\Doviz;
class wordDoviz{
    private $desteklenenParaBirimleri=array("USD","EUR","GBP");
    public function __construct(){
        add_action("admin_menu",array($this,"menuIslemleri"));
        add_action("admin_init",array($this,"ayarAlanlariniOlustur"));
    }

    public function menuIslemleri(){
         add_submenu_page(
            'tools.php', 
            'WordDöviz', 
            'WordDöviz', 
            'manage_options', 
            'word-doviz', 
            array($this,"dovizAyarlari")
        );
    }
    public function wordDovizAciklama(){
      ?>
        <p >
            <?php echo __('wordDoviz eklentisi ile TCMBB yada Investing doviz kurlarını widget alanıda yada shortcode ile kullanabilirsiniz. Bu sayfadan hangi döviz türlerinin takip edilmesini istediğinizi ve kendi ana döviz birimi seçmeniz gerekmektedir.','worddoviz')
            ?>
        </p>
        <?php
    }

    public function kaynakSecimiSelect()
    {
        $options = get_option('worddoviz_settings');
        ?>
        <select name='worddoviz_settings[kaynak_secimi]'>
            <option value='TCMB' <?php @selected($options['kaynak_secimi'], 'TCMB'); ?>>TCMBB</option>
            <option value='INVESTING' <?php @selected( $options['kaynak_secimi'], 'INVESTING' ); ?>>INVESTING</option>
        </select>
        <p class="description"><?php echo __('Döviz bilgilerinin alınacağı kaynağı seçiniz.','worddoviz')?></p>
        <?php
    }
    public function anaDovizSecimi()
    {
        $options = get_option('worddoviz_settings');
        
        ?>
        <select name='worddoviz_settings[ana_doviz]'>
            <?php foreach($this->desteklenenParaBirimleri as $doviz):?>
                <option value='<?php echo $doviz;?>' <?php @selected($options['ana_doviz'], $doviz); ?>><?php echo $doviz?></option>
            <?php endforeach;?>
        </select>
        <p class="description"><?php echo __('Sitenizde kullandığını ana döviz birimini seçiniz.','worddoviz')?></p>
        <?php
    }

    public function kullanilacakDovizSecimi(){
        $dovizBilgileri=wp_cache_get("wooDovizBilgileri");
        
        ?>
        <p><?php _e("Döviz kurları ".$dovizBilgileri["kaynak"]." kaynağından <b>" . date('d.m.Y H:i:s', $dovizBilgileri['guncellenme_zamani']) . "</b> tarihinde güncellendi.", "iyziposplus");?></p>
                        <table class="wc_gateways widefat">
                            <thead>
                                <tr>
                                    <th class="name"><?php _e('Döviz', 'woodoviz');?></th>
                                    <th class="name"><?php _e('Alış Fiyatı', 'woodoviz');?></th>
                                    <th class="name"><?php _e('Satış Fiyatı', 'woodoviz');?></th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($dovizBilgileri["dovizler"] as $birim=>$doviz): ?>

                                <tr>
                                    <td><?php echo $birim; ?></td>
                                    <td><?php echo $doviz['alis']; ?></td>
                                    <td><?php echo $doviz['satis']; ?></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
        <?php
    }
    public function dovizBilgileriniOlustur($kaynak){
        $doviz = new Doviz();
        $dovizBilgileri=array(
            "kaynak"=>$kaynak,
            "guncellenme_zamani"=>time(),
            "dovizler"=>array()
        );
        foreach($this->desteklenenParaBirimleri as $dovizBirimleri){
            $dovizBilgileri["dovizler"][$dovizBirimleri]["alis"]=$doviz->kurAlis($dovizBirimleri);
            $dovizBilgileri["dovizler"][$dovizBirimleri]["satis"]=$doviz->kurSatis($dovizBirimleri);
        }
        // cache kontrolu yapılmalı
        wp_cache_set("wooDovizBilgileri",$dovizBilgileri);
    }

    public function ayarAlanlariniOlustur()
    {        
        $this->dovizBilgileriniOlustur("TCMB");
    
        register_setting('worddoviz', 'worddoviz_settings');

        add_settings_section(
            'worddoviz_section',
            __('Word Doviz Ayarları','worddoviz'),
            array($this,"wordDovizAciklama"),
            'worddoviz'
        );
        add_settings_field(
            'kaynak_secimi', //id
            __('Kaynak Seçimi','worddoviz'), //name
            array($this,"kaynakSecimiSelect"), //callback
            'worddoviz', // page
            'worddoviz_section' //section
        );
        add_settings_field(
            'ana_doviz', //id
            __('Ana Doviz Seçimi','worddoviz'), //name
            array($this,"anaDovizSecimi"), //callback
            'worddoviz', // page
            'worddoviz_section' //section
        );
        add_settings_field(
            'kullanilabilir_doviz_birimleri', //id
            __('Kullanılacak Döviz Seçimi','worddoviz'), //name
            array($this,"kullanilacakDovizSecimi"), //callback
            'worddoviz', // page
            'worddoviz_section' //section
        );
        
        
    }
    static function dovizAyarlari($input) {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        if ( isset( $_GET['settings-updated'] ) ) {
            add_settings_error( 'woodoviz_mesajlar', 'woodoviz_mesajlar',"Ayarlar Kaydedildi" , 'success' );

        }
        settings_errors( 'woodoviz_mesajlar' );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('worddoviz');
                do_settings_sections('worddoviz' );
                submit_button(__('Ayarlari Kaydet','iyzicoinstallment'));
                ?>
            </form>
        </div>
        <?php
    }
}