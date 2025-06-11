<?php
include_once "../../partials/header.php";
include_once "../../partials/navigation.php";

?>
    <link rel="stylesheet" type="text/css" href="../../template/css/profile.css" />

    <title>Profile - FlashUT</title>
    


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>



<script>
let cropper;

document.addEventListener("DOMContentLoaded", () => {
  const userName = document.getElementById("userName");
  const userPic = document.getElementById("userPic");
  const emailInput = document.getElementById("email");
  const academicSpan = document.getElementById("academicID");
  const passwordInput = document.getElementById("password");
  const editLink = document.getElementById("editPassword");
  const saveBtn = document.getElementById("saveBtn");
  const feedback = document.getElementById("feedback");
  const picUploadInput = document.getElementById("picUpload");
  const profilePreview = document.getElementById("profilePreview");
  const cropBtn = document.getElementById("cropBtn");
  const previewImage = document.getElementById("preview");

  fetch('../../controllers/student/profile.php')
    .then(res => res.json())
    .then(data => {
      if (data.success && data.user) {
        userName.textContent = `${data.user.firstName} ${data.user.lastName}`;


      


        profilePreview.src =data.user.pic_path
  ? `../../template/imgProfile/${data.user.pic_path}`
  : `../../template/imgProfile/user.png`; 
        emailInput.textContent = data.user.email;
        academicSpan.textContent = data.user.academicID;
      }
    });
    

   fetch('../../controllers/student/getUserStats.php')
      .then(res => res.json())
      .then(data => {
      if (data.success && data.user) {
            const user = data.user;
            document.getElementById("flashView").innerHTML = `${user.view_count} <br />Flashcard Viewed`;
            document.getElementById("flashAdd").innerHTML = `${user.add_count} <br />Flashcard Added`;
            document.getElementById("totalScores").innerHTML = `${user.score} <br /> Point`;
      }
      });

  editLink.addEventListener("click", (e) => {
    e.preventDefault();
    const isEditing = !passwordInput.hasAttribute("readonly");
    if (isEditing) {
      passwordInput.setAttribute("readonly", true);
      passwordInput.value = "********";
      editLink.textContent = "Change";
      saveBtn.disabled = true;
    } else {
      passwordInput.removeAttribute("readonly");
      passwordInput.value = "";
      passwordInput.focus();
      editLink.textContent = "Cancel";
      saveBtn.disabled = false;
    }
  });

  saveBtn.addEventListener("click", () => {
    const newPassword = passwordInput.value.trim();
    feedback.textContent = "";

    if (newPassword.length < 6) {
      feedback.textContent = "Password must be at least 6 characters.";
      feedback.style.color = "red";
      return;
    }

    fetch('../../controllers/student/profile.php', {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ password: newPassword })
    })
      .then(res => res.json())
      .then(data => {
        feedback.textContent = data.message;
        feedback.style.color = data.success ? "green" : "red";
        if (data.success) {
          passwordInput.value = "********";
          passwordInput.setAttribute("readonly", true);
          saveBtn.disabled = true;
          editLink.textContent = "Change";
        }
      })
      .catch(() => {
        feedback.textContent = "Something went wrong.";
        feedback.style.color = "red";
      });
  });

  document.getElementById("picUpload").addEventListener("change", () => {
  const file = document.getElementById("picUpload").files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append("profilePic", file);

  fetch("../../controllers/uploadProfilePic.php", {
    method: "POST",
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.getElementById("profilePreview").src = `../../template/imgProfile/${data.path}?v=${Date.now()}`;
      } else {
        alert(data.message || "Upload failed.");
      }
    })
    .catch(() => alert("Upload error"));
});
});
</script>

      <div class="profile">

          <div class="user-info user">
  <form id="uploadForm" enctype="multipart/form-data">
    <label for="picUpload">
      <img id="profilePreview" src="../../template/imgProfile/user.png" alt="Profile Picture" class="course-image" style="cursor: pointer;" />
    </label>
    <input type="file" name="profilePic" id="picUpload" accept=".jpg,.jpeg,.png,.gif,.webp,.bmp" style="display: none;" />  </form>
            <h1 id = "userName" class="title">YourName</h1>
          </div>


          <div class="contributions">

            <div class="smallBox">
              <svg xmlns="http://www.w3.org/2000/svg" fill="#751F1F" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6 eyeIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
              <span id="flashView" class="flashcardViewedtext">.. <br />Flashcard Viewed</span>
            </div>

            <div class="bigBox">
              <img class="awardIcon" src="../../template/imgProfile/award.svg" alt="Award" />
              <span  id="totalScores" class="flashcardViewedtext">.. Point</span>
            </div>

            <div class="smallBox">
              <img class="flashIcon" src="../../template/imgProfile/frame.svg" alt="Frame" />
              <span id="flashAdd" class="flashcardViewedtext">.. <br />Flashcard Added</span>
            </div>

          </div>



          <div class="user-container user">
  <div class="user-data-container">

    <div class="email-container">
      <h3 class="email-account-label">Email account</h3>
      <span id="email" class="yournamegmailcom"> </span>
    </div>

    <div class="academic-container">
      <h3 class="academic-id-label">Academic ID</h3>
      <span id="academicID" ></span>
    </div>

    <div class="pass-container">
  <h3 class="password-label">Password</h3>
  <div class="password-wrapper">
    <input type="password" id="password" class="change" placeholder="********" readonly>
    <a href="#" id="editPassword">Change</a>
  </div>
</div>

  </div>

  
<button class="button" id="saveBtn" disabled>Save Change</button>
<div id="feedback"></div>
</div>

      </div>
  </body>
</html>
