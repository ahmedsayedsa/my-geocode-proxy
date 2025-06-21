<?php
// تعطيل الكاش لضمان رؤية أحدث نسخة
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

echo "Hello World! The PHP script is working on Vercel.";
?>
