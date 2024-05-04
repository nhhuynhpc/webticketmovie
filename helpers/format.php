<?php
class Format
{
    public function date_format($date, $format = "Y/m/d")
    {
        $date = date($format, strtotime($date));
        return $date;
    }

    public function hour_format($date, $format = "H:i:s")
    {
        $date = date($format, strtotime($date));
        return $date;
    }

    public function translate_date_format($englishDate)
    {
        $englishDays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $vietnameseDays = array('Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy', 'Chủ Nhật');

        $dayOfWeek = date('l', strtotime($englishDate));

        $vietnameseDayOfWeek = str_replace($englishDays, $vietnameseDays, $dayOfWeek);

        return $vietnameseDayOfWeek;
    }

    public function text_shorten($text, $limit = 140)
    {
        $text = $text . "";
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, " "));
        $text = $text . "......";
        return $text;
    }

    public function validation($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function title()
    {
        $path = $_SERVER["SCRIPT_FILENAME"];
        $title = basename($path, ".php");

        if ($title == "index") {
            $title = "Trang chủ";
        } elseif ($title == "chiTietSanPham") {
            $title = "Chi tiết sản phẩm";
        }
        return $title;
    }
}
?>