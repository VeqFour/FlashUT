<?php
include_once "../../partials/header.php";
include_once "../../partials/auth_admin.php"; 
include_once "../../partials/navigation.php";

?>

<link rel="stylesheet" type="text/css" href="../../template/css/flashcard.css" />

<title>Flashcards - FlashUT</title>

      


<script>
document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const section_id = urlParams.get('section_id');
    const group_id = urlParams.get('group_id');
    const group_name = urlParams.get('group_name');
    const course_name = urlParams.get('course_name');
    const course_image = urlParams.get('course_image'); 


    const coursePic = document.querySelector(".course-pic");

    const groupTitleEl = document.querySelector(".group-titel");
    const flashcardTotalNoEl = document.querySelector(".flashcard-total-no");
    const questionEl = document.querySelector("#QA-section .question");
    const answerEl = document.querySelector("#AQ-section .answer");
    const flashcardClick = document.querySelector(".flip-container");
    const nextBtn = document.querySelector(".next-vector");
    const prevBtn = document.querySelector(".previous-vector");
    const flashcardNoEl = document.querySelector(".flashcard-total-No");
    
    

    const userInfo =document.getElementById("userInfo");





    let flashcards = [];
    let currentIndex = 0;
    // let flipped = false;

    

    function updateCard() {
      const flashcard = flashcards[currentIndex];
      const commentSection = document.querySelector(".comment-section");


    if (flashcards.length > 0) {
        questionEl.textContent = flashcard.question;
        answerEl.textContent = flashcard.answer;

        
        const createdByNote = document.querySelector(".created-by-admin");
        if (flashcard.role === "admin") {
          createdByNote.style.display = "block";
        } else {
          createdByNote.style.display = "none";
        }
        flashcardNoEl.textContent = `${currentIndex + 1} / ${flashcards.length}`;
       

        uploadComment(flashcard.flashcard_id);
      //   const newUrl = new URL(window.location);
      //   newUrl.searchParams.set("flashcard_id", currentFlashcardId);
      //   window.history.replaceState({}, '', newUrl);
        }else {
          questionEl.textContent = "No flashcards yet In this group!";
          answerEl.textContent = "No flashcards yet In this group!";
          commentSection.style.display = "none";
          nextBtn.classList.add("no-hover");
          prevBtn.classList.add("no-hover");


        }

        
        if (currentIndex === flashcards.length - 1) {
        nextBtn.classList.add("no-hover");
    } else {
        nextBtn.classList.remove("no-hover");
    }

    if (currentIndex === 0) {
        prevBtn.classList.add("no-hover");
    } 
    else {
        prevBtn.classList.remove("no-hover");
    } 
    }
    

    


    flashcardClick.addEventListener("click", function () {
    flashcardClick.classList.toggle("flipped");

    
});
    

    nextBtn.addEventListener("click", () => {
        if (currentIndex < flashcards.length - 1) {
            currentIndex++;
            updateCard();

            if (flashcardClick.classList.contains("flipped")) {
              
              flashcardClick.classList.toggle("flipped");
           
          } 

            uploadComment(flashcards[currentIndex].flashcard_id);
        }

    });

    prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCard();

            if (flashcardClick.classList.contains("flipped")) {
              
              flashcardClick.classList.toggle("flipped");
           
          } 
            uploadComment(flashcards[currentIndex].flashcard_id);
        }
    });

    fetch(`../../controllers/flashcard.php?group_id=${group_id}&group_name=${group_name}`)
        .then(res => res.json())
        .then(data => {
            image_path=data.course.image_path;
            flashcards = data.flashcards;
            userFullName="Dr. "+ data.user.firstName+ " " +data.user.lastName;
            userPic=data.user.pic_path;
            
            flashcardTotalNoEl.textContent = `${flashcards.length} Flashcards`;
            coursePic.innerHTML = `<img class="course-pic" src="../../template/imgCourses/${image_path}" alt="Course Image" />`;  
            groupTitleEl.textContent = data.group_name; 
            userInfo.innerHTML=     `<img class="user-pic" src="../../template/imgProfile/${userPic}" alt="userPic"  onerror="this.onerror=null;this.src='../../template/imgProfile/instructor.png';" /> 
                                        <span class="user-full-name small-paragraph">${userFullName}</span>`;

            updateCard();
        })
        .catch(err => {
            console.error("Failed to load flashcards:", err);
        });
        



       

        function uploadComment(flashcard_id){
          fetch(`../../controllers/comments.php?group_id=${group_id}&flashcard_id=${flashcard_id}`)
            .then(res => res.json())
            .then(comments => {
                const allCommentsEl = document.querySelector(".all-comments");
                allCommentsEl.innerHTML = ""; 

                if (comments.length === 0) {
                    allCommentsEl.innerHTML = "<p class='small-paragraph'>No comments yet.</p>";
                    return;
                }

                comments.forEach(comment => {
  const isAdmin = comment.role === "admin";
  const namePrefix = isAdmin ? "Dr. " : "";
  const adminClass = isAdmin ? "admin-comment" : "";
  const defaultImg = isAdmin ? "instructor.png" : "user.png";


  const createdAt = new Date(comment.created_at);
  const now = new Date();
  const diffMs = now - createdAt;
  const diffMinutes = Math.floor(diffMs / 60000);
  const timeAgo =
    diffMinutes < 1 ? "just now" :
    diffMinutes < 60 ? `${diffMinutes} minutes ago` :
    diffMinutes < 1440 ? `${Math.floor(diffMinutes / 60)} hours ago` :
    `${Math.floor(diffMinutes / 1440)} days ago`;

const commentHTML = `
  <div class="comment-continer ${adminClass}">
    <div class="comment-writer">
      <div class="pic-name-section_comment">
        <img class="user-pic" 
             src="../../template/imgProfile/${comment.pic_path || defaultImg}" 
             alt="userPic"
             onerror="this.onerror=null;this.src='../../template/imgProfile/${defaultImg}'" />
             
  <div class="name-timestamp-row">
    <div class="user-full-name small-paragraph">${namePrefix}${comment.firstName} ${comment.lastName}</div>
    <div class="comment-timestamp small-paragraph">${timeAgo}</div>
  </div>
      </div>
    </div>
    <div class="content-container">
      <p class="content">${comment.content}</p>
    </div>
  </div>
`;
  allCommentsEl.innerHTML += commentHTML;
});
            })
            .catch(err => {
                console.error("Failed to load comments:", err);
            });
    } 


    
document.querySelector(".send-comment-btn").addEventListener("click", function () {
    const commentText = document.querySelector(".new-comment-textarea").value.trim();
    
    if (commentText === "") {
      alert("Please enter a comment.");
      return;
    }

    fetch("../../controllers/comments.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            content: commentText,
            flashcard_id: flashcards[currentIndex].flashcard_id,
            group_id: group_id
        })
    })
    .then(res => res.json())
    .then(response => {
      const messageBox = document.getElementById("comment-message");

        if (response.success) {
            document.querySelector(".new-comment-textarea").value = "";
            messageBox.textContent = " Your Comment added successfully!";
            messageBox.classList.remove("error");
            messageBox.style.display = "block";
            uploadComment(flashcards[currentIndex].flashcard_id); 
        } else {
            messageBox.textContent = " Failed to add comment.";
            messageBox.classList.add("error");
            messageBox.style.display = "block";
        }
    })
    .catch(err => {
        console.error("Error submitting comment:", err);
    });
});
});


</script>

<style>

.name-timestamp-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    gap: 10px;
}

.comment-timestamp {
    font-size: 0.75rem;
    color: #888888;
    white-space: nowrap;
    margin-left: auto; /* forces it to the right */
}
.comment-continer.admin-comment {
  border-left: 4px solid #9A2828;
}

.comment-continer.admin-comment .user-full-name {
  color: #9A2828;
  font-weight: bold;
  margin-left: 10px;
}
.flashcardClick {
  transition: transform 0.7s;
  transform-style: preserve-3d;
  cursor: pointer;
  position: relative;
}
.flashcardClick.flipped {
  transform: rotateY(180deg);
}
.questionContainer, .answerContainer {
  backface-visibility: hidden;
  position: absolute;
  width: 100%;
}
.answerContainer {
  transform: rotateY(180deg);
  
  display: none;
}
.comment-message {
display: flex;
align-self: flex-start;
  font-size: 14px;
  font-family: 'Baloo Bhai', sans-serif;
  color: green;
  display: none;
}

.comment-message.error {
  color: red;
}


.flip-container {
  width: 550px;
  border-radius: 20px;
  height: 400px;
  position: relative;
}

.flipper {
  transition: transform 0.8s ease;
  transform-style: preserve-3d;
  position: relative;
}

.front, .back {
  backface-visibility: hidden;
  position: absolute;
  width: 100%;
  height: fit-content;
  
}

.front {
  z-index: 2;
}

.back {
  transform: rotateY(180deg);
  z-index: 1;
}

.flip-container.flipped .flipper {
  transform: rotateY(180deg);
}

.flashcard .QA-container {
  position: relative; 
  height: 450px;
  width: 100%;
}

.created-by-admin {
  display: none;
  color: rgb(0, 0, 0);
  font-weight: bold;
  font-size: 16px;
  font-family: 'Baloo Bhai 2', sans-serif;
  text-align: center;
}





</style>



    
  
      <div class="flashcard screen">
      
        <div class="flashcard-page-container">
            <div class="page-titel">
              
             <a href="javascript:history.back()" class="back-arrow-link">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#9A2828" stroke="#9A2828" stroke-width="1.1"  class="size-6 arrow-back-to-previous-page">
                   <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                  </svg>
            </a>

              <h1 class="titel-content">Flashcard</h1>
            </div >

      <div class="mainParts">
          <div class="course-pic">     </div>


          
          <div class="flex-row-1 flex-row-3">
          






            <div  id="mianFlashcard" class="card-container">
              <div class="group-name">
                <h2 class="flashcard-total-no"></h2>
                <h1 class="group-titel"></h1>
                
              </div>
              <span class="created-by-admin">Created by Instructor</span>




              <div class="flip-container">
              
                         <div class="flipper" id="flipper">
                                    <!-- Front: QA-section -->
                                    <div class="front QA-section" id="QA-section">
                                          <div class="QA-container">
                                                <div class="A-container">
                                                      <p class="answer"> STILL LOADING..</p>
                                                </div>
                                                <div class="Q-container">
                                                       <p class="question" >LOADING...</p>

                                                     
                                                  </div>
                                          </div>

                                  
                                    </div>

                                    <!-- Back: AQ-section -->
                                    <div  class="back QA-section" id="AQ-section">
                                          <div class="QA-container">
                                                <div class="Q-container">
                                                      <p class="question"></p>
                                                </div>
                                                <div class="A-container">
                                                       <p class="answer" >STILL LOADING..</p>
                                                </div>
                                          </div>

                                         
                                    </div>
                         </div>
                  </div>






              <div class="next_-previous_-section">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 previous-vector">
                         <path d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
                   </svg>
                
                  <h2 class="flashcard-total-No">Wait</h2>
                      
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 22" stroke-width="1.5" stroke="currentColor" class="size-6 eyeViewd">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          </svg>

                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" class="size-6 eyeClosed">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                          </svg>


                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 next-vector">
                        <path d="M5.055 7.06C3.805 6.347 2.25 7.25 2.25 8.69v8.122c0 1.44 1.555 2.343 2.805 1.628L12 14.471v2.34c0 1.44 1.555 2.343 2.805 1.628l7.108-4.061c1.26-.72 1.26-2.536 0-3.256l-7.108-4.061C13.555 6.346 12 7.249 12 8.689v2.34L5.055 7.061Z" />
                  </svg>

              </div>


            </div>





            <div class="comment-section">
            <div id="comment-message" class="comment-message"></div>

              <div class="all-comments">

                <div class="comment-continer">

                  <div class="comment-writer">

                    <div class="pic-name-section_comment">
                      <img class="user-pic" src="../template/imgFlashcard/userpic.svg" alt="userPic" />
                      <span class="user-full-name small-paragraph">Anonumens</span>
                    </div>

                  </div>
                  <div class="content content-2">
                    <p class="add-comment-placeholder">...</p>
                  </div>

                </div>
                
              </div>

              <div class="newComment">
                <div class="comment-writer">
                  <div id= "userInfo" class="pic-name-section_comment">
                    <img   class="user-pic" src="../template/imgFlashcard/userpic-2.svg" alt="userPic" />
                    <span class="user-full-name">user</span>
                  </div>
                </div>
                <div class="content-container">
                <textarea class="new-comment-textarea content" placeholder="Add comment..." rows="3"></textarea>
                <button class="send-comment-btn">Send</button>
                </div>

              </div>
             


            </div>
          </div>
          </div>
        </div>
      </div>
 
  











 
</body>
</html>