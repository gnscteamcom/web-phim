<?php
class QuocGiaModel extends MyModel{
    public $id ;
    public $ten_quoc_gia;
    protected $tb_name = 'tb_quoc_gia';

    public function getList($params = null){

        $sql = "SELECT * FROM $this->tb_name ORDER  BY id DESC ";

        $res = $this->ExecQuery($sql); // hàm exec này được kế thừa từ lớp cha MyModel.

        $data = array();

        while($row = mysqli_fetch_assoc($res)){
            $data[] = $row;
        }
        mysqli_free_result($res);

        return $data;
    }

    /**
     * Hàm xử lý thêm mới NSX
     * @param null $params
     */
    public function SaveNew($params = null){

        $sqlInsert = "INSERT INTO $this->tb_name(ten_quoc_gia)
          VALUES ('$this->ten_quoc_gia')";

        $res = mysqli_query($this->getConn(),$sqlInsert);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không insert được";
    }

    public function loadOne($id){
        $sql = "SELECT * FROM $this->tb_name WHERE id= $id";
        $objRes = new stdClass();
        $res = mysqli_query($this->getConn(), $sql);
        if(mysqli_errno($this->getConn()))
        {
            $objRes->error = mysqli_error($this->getConn());
            return $objRes;
        }

        if(mysqli_num_rows($res) != 1){
            $objRes->error = "Lỗi không xác định bản ghi cần chỉnh sửa";
            return $objRes;
        }

        $row = mysqli_fetch_assoc($res); // lấy dòng dữ liệu
        foreach($row as $field_name => $value)
            $objRes->$field_name = $value;

        return $objRes;

    }

    public function SaveUpdate(){

        $sqlUpdate = "Update $this->tb_name SET ten_quoc_gia = '$this->ten_quoc_gia'
        
                    WHERE id = $this->id
                    ";


        $res = mysqli_query($this->getConn(),$sqlUpdate);

        if(mysqli_errno($this->getConn()))
            return mysqli_error($this->getConn());

        if($res)
            return mysqli_insert_id($this->getConn()); // trả về ID mới
        else
            return "Không cập nhật  được";

    }
}