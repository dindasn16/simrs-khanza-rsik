<?php
    if(strpos($_SERVER['REQUEST_URI'],"pages")){
        exit(header("Location:../index.php"));
    }
?>
<div id="post">
    <div align="center" class="link">
        <a href=?act=InputEmergencyIndex&action=TAMBAH>| Input Data |</a>
        <a href=?act=ListEmergencyIndex>| List Data |</a>
        <a href=?act=HomeAdmin>| Menu Utama |</a>
    </div>  
    <div class="entry">
        <form name="frm_pelatihan" onsubmit="return validasiIsi();" method="post" action="" enctype=multipart/form-data>
            <?php
                echo "";
                $action             = isset($_GET['action'])?$_GET['action']:NULL;
                $kode_emergency     = validTeks(str_replace("_"," ",isset($_GET['kode_emergency'])?$_GET['kode_emergency']:NULL));
                if($action == "TAMBAH"){
                    $kode_emergency = validTeks(str_replace("_"," ",isset($_GET['kode_emergency'])?$_GET['kode_emergency']:NULL));
                    $nama_emergency = "";
                    $indek          = "";
                }else if($action == "UBAH"){
                    $_sql           = "SELECT * FROM emergency_index WHERE emergency_index.kode_emergency='$kode_emergency'";
                    $hasil          = bukaquery($_sql);
                    $baris          = mysqli_fetch_row($hasil);
                    $kode_emergency = $baris[0];
                    $nama_emergency = $baris[1];
                    $indek          = $baris[2];
                }
                echo"<input type=hidden name=kode_emergency value=$kode_emergency><input type=hidden name=action value=$action>";
            ?>
            <table width="100%" align="center">
                <tr class="head">
                    <td width="31%" >Kode</td><td width="">:</td>
                    <td width="67%"><input name="kode_emergency" class="text" onkeydown="setDefault(this, document.getElementById('MsgIsi1'));" type=text id="TxtIsi1" class="inputbox" value="<?php echo $kode_emergency;?>" size="10" maxlength="3" pattern="[a-zA-Z0-9, ./@_]{1,3}" title=" a-zA-Z0-9, ./@_ (Maksimal 3 karakter)" autocomplete="off" autofocus/>
                    <span id="MsgIsi1" style="color:#CC0000; font-size:10px;"></span>
                    </td>
                </tr>
                <tr class="head">
                    <td width="31%" >Emergency Index</td><td width="">:</td>
                    <td width="67%"><input name="nama_emergency" class="text" onkeydown="setDefault(this, document.getElementById('MsgIsi2'));" type=text id="TxtIsi2" class="inputbox" value="<?php echo $nama_emergency;?>" size="40" maxlength="100" pattern="[a-zA-Z0-9, ./@_()]{1,100}" title=" a-zA-Z0-9, ./@_() (Maksimal 100 karakter)" autocomplete="off"/>
                    <span id="MsgIsi2" style="color:#CC0000; font-size:10px;"></span>
                    </td>
                </tr>
                <tr class="head">
                    <td width="31%" >Index</td><td width="">:</td>
                    <td width="67%"><input name="indek" class="text" onkeydown="setDefault(this, document.getElementById('MsgIsi3'));" type=text id="TxtIsi3" class="inputbox" value="<?php echo $indek;?>" size="10" maxlength="4" pattern="[0-9-]{1,4}" title=" 0-9- (Maksimal 4 karakter)" autocomplete="off"/>
                    <span id="MsgIsi3" style="color:#CC0000; font-size:10px;"></span>
                    </td>
                </tr>
            </table>
            <div align="center"><input name=BtnSimpan type=submit class="button" value="SIMPAN">&nbsp<input name=BtnKosong type=reset class="button" value="KOSONG"></div>
            <?php
                $BtnSimpan=isset($_POST['BtnSimpan'])?$_POST['BtnSimpan']:NULL;
                if (isset($BtnSimpan)) {
                    $kode_emergency    = trim($_POST['kode_emergency']);
                    $kode_emergency    = validTeks4($kode_emergency,3);
                    $nama_emergency    = trim($_POST['nama_emergency']);
                    $nama_emergency    = validTeks6($nama_emergency,100);
                    $indek             = validangka(trim($_POST['indek']));
                    if ((isset($kode_emergency))&&(isset($nama_emergency))&&(isset($indek))) {
                        switch($action) {
                            case "TAMBAH":
                                Tambah(" emergency_index "," '$kode_emergency','$nama_emergency','$indek' ", " emergency index " );
                                echo"<html><head><title></title><meta http-equiv='refresh' content='1;URL=?act=InputEmergencyIndex&action=TAMBAH'></head><body></body></html>";
                                break;
                            case "UBAH":
                                Ubah(" emergency_index "," nama_emergency='$nama_emergency',indek='$indek' WHERE kode_emergency='$kode_emergency' ", " emergency index ");
                                echo"<html><head><title></title><meta http-equiv='refresh' content='2;URL=?act=ListEmergencyIndex'></head><body></body></html>";
                                break;
                        }
                    }else{
                        echo 'Semua field harus isi..!!';
                    }
                }
            ?>
        </form>
    </div>
</div>

