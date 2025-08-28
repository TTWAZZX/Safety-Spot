<?php
include("connection.php");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Spot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kanit', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div id="app-container" class="text-center p-8 bg-white rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold text-emerald-600 mb-4">Safety Spot ✨</h1>
        
        <!-- ส่วนแสดงสถานะ -->
        <div id="status-message" class="text-gray-500">
            <p>กำลังเริ่มต้นแอปพลิเคชัน...</p>
        </div>

        <!-- ส่วนแสดงข้อมูลผู้ใช้ (เมื่อ login สำเร็จ) -->
        <div id="user-profile" class="hidden mt-6">
            <img id="profile-picture" src="" alt="Profile Picture" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-emerald-200">
            <p class="text-xl">สวัสดี, <span id="display-name" class="font-semibold"></span>!</p>
        </div>
    </div>

    <!-- LIFF SDK -->
    <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
    <script>
        async function main() {
            const statusMessage = document.getElementById('status-message');
            try {
                // **กรุณากรอก LIFF ID ของคุณที่นี่**
                await liff.init({ liffId: "2007053300-9xLKdwZp" }); 
                
                statusMessage.innerText = "กำลังตรวจสอบการล็อกอิน...";

                if (!liff.isLoggedIn()) {
                    statusMessage.innerText = "กรุณาล็อกอินเพื่อใช้งาน";
                    // ถ้ายังไม่ล็อกอิน จะ redirect ไปหน้าล็อกอินของ LINE
                    liff.login(); 
                } else {
                    statusMessage.innerText = "ล็อกอินสำเร็จ! กำลังดึงข้อมูลโปรไฟล์...";
                    
                    // ดึงข้อมูลโปรไฟล์ผู้ใช้
                    const profile = await liff.getProfile();
                    
                    // แสดงผลข้อมูล
                    document.getElementById('profile-picture').src = profile.pictureUrl;
                    document.getElementById('display-name').innerText = profile.displayName;
                    
                    // ซ่อนข้อความสถานะและแสดงข้อมูลโปรไฟล์
                    statusMessage.classList.add('hidden');
                    document.getElementById('user-profile').classList.remove('hidden');

                    // TODO: ส่ง ID Token ไปยัง Backend เพื่อทำการยืนยันตัวตนและบันทึกข้อมูล
                    // const idToken = liff.getIDToken();
                    // console.log("ID Token:", idToken); 
                    // fetch('/api/login', { method: 'POST', body: JSON.stringify({ token: idToken }) });
                }

            } catch (error) {
                console.error('LIFF Initialization failed', error);
                statusMessage.innerText = "เกิดข้อผิดพลาดในการเริ่มต้น LIFF App";
            }
        }

        // เรียกใช้งานฟังก์ชันหลัก
        main();
    </script>
</body>
</html>