<?php
include_once "../../partials/header.php";
include_once "../../partials/navigation.php";
?>

  <title>TrackFlashcards - FlashUT</title>
  <link rel="stylesheet" href="../../template/css/followFlashcards.css">

  <style>
    body {
      background: var(--black-haze, #f8f8f8);
      margin: 0;
      padding: 0;
    }
    .options-container, .section-container {
    display: flex;
    justify-content: center;   
    align-items: center;       
    flex-wrap: wrap;
    gap: 30px;
    padding: 30px 20px;
    width: 100%;
    height: auto;  
    text-align: center;
    box-sizing: border-box;
    
}

    .section-container {
      flex-direction: column;
      gap: 40px;



    }
    .option-card {
      background: white;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
      border-radius: 15px;
      width: 280px;
      height: 200px;
      padding: 20px;
      cursor: pointer;
      transition: transform 0.3s;
      position: relative;
    }
    .option-card:hover {
      transform: translateY(-10px);
    }
    .option-card h2 {
      margin: 10px 0;
      font-size: 22px;
      color: #9A2828;
    }
    .option-card p {
      font-size: 16px;
      color: #555;
    }
    .flashcard-count {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #9A2828;
      color: white;
      padding: 5px 10px;
      border-radius: 50px;
      font-size: 14px;
      font-weight: bold;
    }
    .section-content {
      width: 100%;
      max-width: 1000px;
      margin: auto;
    }
    .flashcard-list {
      margin-top: 30px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .flashcard-item {
      background: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
      text-align: left;
    }
    .edit-button {
      margin-top: 10px;
      background-color: #9A2828;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 8px;
      cursor: pointer;
    }
    /* Loading spinner */
    .spinner {
      border: 6px solid #f3f3f3;
      border-top: 6px solid #9A2828;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin: 100px auto;
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

.QA-container {
  position: relative; 
  height: 450px;
  width: 100%;
}
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    @media (max-width: 768px) {
      .option-card {
        width: 90%;
      }
    }


    .ai-result-message {
  background-color: #fff8dc;
  padding: 16px;
  border: 1px solid #ffd700;
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 16px;
  color: #333;
  border-radius: 8px;
  z-index: 1000;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}


.edit-button, .confirm-question, .AddingBtn {
  font-family: 'Baloo Bhai 2', sans-serif;
  background-color: #9A2828;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s, transform 0.2s;
  margin: 5px;
}

.edit-button:hover, .confirm-question:hover, .AddingBtn:hover {
  background-color: #b53b3b;
  transform: scale(1.05);
}

.edit-button:disabled, .confirm-question:disabled, .AddingBtn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
  </style>

 <div id="loading" class="followFlashcards">
 <div class="page-titel">
                  <a href="followFlashcards.php" class="back-arrow-link">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#9A2828" stroke="#9A2828" stroke-width="1.1"  class="size-6 arrow-back-to-previous-page">
                              <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                              </svg>  
                  </a>
            </div>


  <div id="mainOptions" class="options-container" style="display: none;">

  <div class ="titels">
                  <h1 class="keep-flashin-smart-add-a-card">Track your Flashcards!</h1>
                  <h2 id= "reviewTitel" class="submit-your-sentense">What type you want to Track?</h2>
            </div>


  
    <div class="option-card" onclick="showSection('pending')">
      <div class="flashcard-count" id="pending-count">0</div>
      <h2>Pending</h2>
      <p>Waiting for admin review. Be patient!</p>
    </div>
    <div class="option-card" onclick="showSection('approved')">
      <div class="flashcard-count" id="approved-count">0</div>
      <h2>Approved</h2>
      <p>Congrats! Your flashcards are approved.</p>
    </div>
    <div class="option-card" onclick="showSection('rejected')">
      <div class="flashcard-count" id="rejected-count">0</div>
      <h2>Rejected</h2>
      <p>Correct and resubmit your flashcards!</p>
    </div>
  </div>

  <div id="sectionContainer" class="section-container" style="display: none;">
           

            <div class="group-name">
                  <h1 class="submit-your-sentense" id="section-title">Loading...</h1>
            </div>


            <div class="card-container">
                        <div class="group-name">
                              <h1 class="group-titel" id="courseName">Course Name</h1>
                              <h2 class="flashcard-total-no" id="flashcardTotal"></h2>
                        </div>



                   <div class="flip-container">
            
                         <div class="flipper" id="flipper">
                                    <!-- Front: QA-section -->
                                    <div class="front QA-section" id="QA-section">
                                          <div class="QA-container">
                                                <div class="A-container"></div>
                                                <div class="Q-container">
                                                       <p class="question" >LOADING...</p>
                                                       <textarea style="display: none;" class="questionArea" placeholder="Type your question here" rows="3"></textarea>
                                                </div>
                                          </div>

                                  
                                    </div>

                                    <!-- Back: AQ-section -->
                                    <div  class="back QA-section" id="AQ-section">
                                          <div class="QA-container">
                                                <div class="Q-container">
                                                </div>
                                                <div class="A-container">
                                                       <p class="answer" >STILL LOADING..</p>
                                                       <textarea style="display: none;" class="answerArea" placeholder="Type your answer here" rows="3"></textarea>

                                                </div>
                                          </div>

                                         

                                         
                                    </div>
                         </div>
                  </div>
       </div>



            <div class="next_-previous_-section">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 previous-vector">
                                    <path d="M9.195 18.44c1.25.714 2.805-.189 2.805-1.629v-2.34l6.945 3.968c1.25.715 2.805-.188 2.805-1.628V8.69c0-1.44-1.555-2.343-2.805-1.628L12 11.029v-2.34c0-1.44-1.555-2.343-2.805-1.628l-7.108 4.061c-1.26.72-1.26 2.536 0 3.256l7.108 4.061Z" />
                              </svg>
                              
                              <h2 class="flashcard-total-No" id="flashcardNumber">1/1</h2>

                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="#B5B5B5" class="size-6 next-vector">
                                    <path d="M5.055 7.06C3.805 6.347 2.25 7.25 2.25 8.69v8.122c0 1.44 1.555 2.343 2.805 1.628L12 14.471v2.34c0 1.44 1.555 2.343 2.805 1.628l7.108-4.061c1.26-.72 1.26-2.536 0-3.256l-7.108-4.061C13.555 6.346 12 7.249 12 8.689v2.34L5.055 7.061Z" />
                              </svg>
            </div>

                        <div style="display: none;" class="BtnsContainer">
                              <button id="edit" class="confirm-question">Edit</button>
                              <button id="add" class="AddingBtn">Adding</button>
                        </div>
  </div>
  </div>

  <script>

let allFlashcards = { pending: [], approved: [], rejected: [] };
let currentFlashcards = [];
let currentIndex = 0;

let currentType = "";


const EditQ_Btn = document.querySelector("#AQ-section .confirm-question");
const question = document.querySelector("#QA-section .question");
const answer = document.querySelector("#AQ-section .answer");


const BtnsContainer = document.querySelector(".BtnsContainer");
const questionArea = document.querySelector(".questionArea");
const answerArea = document.querySelector(".answerArea");
const editBtn = document.getElementById("edit");
const addBtn = document.getElementById("add");

addBtn.style.display = "none";




function showSection(type) {
      currentType = type;
        document.getElementById('mainOptions').style.display = 'none';
        document.getElementById('sectionContainer').style.display = 'flex';
        document.getElementById('section-title').textContent = {
          pending: 'Your flashcards are awaiting admin approval. Stay positive!',
          approved: 'Awesome! Your flashcards are approved.',
          rejected: 'Keep pushing! Correct and resubmit your flashcards.'
        }[type];
        currentFlashcards = allFlashcards[type];

        currentIndex = 0;
        updateCard(currentType);
      }

     
      const questionEl = document.querySelector("#QA-section .question");
      const answerEl = document.querySelector("#AQ-section .answer");
      const flashcardNoEl = document.getElementById("flashcardNumber");
      const flashcardClick = document.querySelector(".flip-container");
      const nextBtn = document.querySelector(".next-vector");
      const prevBtn = document.querySelector(".previous-vector");

      function fetchFlashcards() {
        fetch('../../controllers/student/flashcardStatus.php')
          .then(res => res.json())
          .then(data => {
            allFlashcards = data;
            document.getElementById('mainOptions').style.display = 'flex';
            document.getElementById('pending-count').textContent = data.pending.length;
            document.getElementById('approved-count').textContent = data.approved.length;
            document.getElementById('rejected-count').textContent = data.rejected.length;
          })
          .catch(err => {
            alert('Failed to load flashcards');
          });
      }

      function updateCard(currentType) {
    if (currentFlashcards.length === 0) {
        questionEl.textContent = "No flashcards in this category.";
        answerEl.textContent = "Try a different option.";
        flashcardNoEl.textContent = "0 / 0";

        BtnsContainer.style.display = "none";
        const whyBtn = document.getElementById("whyFeedbackBtn");
        if (whyBtn) whyBtn.style.display = "none";

        return;
    }

    const flashcard = currentFlashcards[currentIndex];
    questionEl.textContent = flashcard.question;
    answerEl.textContent = flashcard.answer || "No answer provided";
    flashcardNoEl.textContent = `${currentIndex + 1} / ${currentFlashcards.length}`;
    document.getElementById("courseName").textContent = flashcard.course_name || "";
    document.getElementById("flashcardTotal").textContent = `${currentFlashcards.length} Flashcards`;

    nextBtn.classList.toggle("no-hover", currentIndex >= currentFlashcards.length - 1);
    prevBtn.classList.toggle("no-hover", currentIndex === 0);

    if (currentType === "rejected") {
        editFlashcard();

        const feedback = flashcard.feedback || "No feedback provided.";
        let whyBtn = document.getElementById("whyFeedbackBtn");

        if (!whyBtn) {
            whyBtn = document.createElement("button");
            whyBtn.id = "whyFeedbackBtn";
            whyBtn.textContent = "Why?";
            whyBtn.classList.add("why-feedback-btn");

            const container = document.querySelector(".group-name");
            container.appendChild(whyBtn);

          
        }
        whyBtn.onclick = () => {
         alert(`Feedback:\n\n${feedback}`);
          };

        whyBtn.style.display = "inline-block";
    } else {
        BtnsContainer.style.display = "none";
        const whyBtn = document.getElementById("whyFeedbackBtn");
        if (whyBtn){
          whyBtn.style.display = "none";
        }
    }
}

      

      flashcardClick.addEventListener("click", () => flashcardClick.classList.toggle("flipped"));

      nextBtn.addEventListener("click", () => {
        if (currentIndex < currentFlashcards.length - 1) {
          currentIndex++;
          flashcardClick.classList.remove("flipped");
          updateCard(currentType);
        }
      });

      prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
          currentIndex--;
          flashcardClick.classList.remove("flipped");
          updateCard(currentType);
        }
      });




      function editFlashcard(){

            
              BtnsContainer.style.display="flex";





            

              let editing = false; 

editBtn.addEventListener("click", function (e) {
    e.stopPropagation(); // prevent flip when clicking edit

    if (!editing) {
    question.style.display = "none";
    answer.style.display = "none";

    questionArea.style.display = "flex";
    answerArea.style.display = "flex";

    questionArea.value = question.textContent.trim();
    answerArea.value = answer.textContent.trim();

    editBtn.textContent = "Cancel Edit";
    addBtn.style.display = "inline-block";  
    editing = true;

} else {
    question.style.display = "block";
    answer.style.display = "block";

    questionArea.style.display = "none";
    answerArea.style.display = "none";

    editBtn.textContent = "Edit";
    addBtn.style.display = "none";  
    editing = false;
}
    // Prevent flip when clicking inside the textareas
questionArea.addEventListener("click", (e) => e.stopPropagation());
answerArea.addEventListener("click", (e) => e.stopPropagation());
});
            

}

addBtn.addEventListener("click", function () {
    const flashcardId = currentFlashcards[currentIndex].flashcard_id; 

    const updatedQuestion = questionArea.value.trim();
    const updatedAnswer = answerArea.value.trim();

    const originalQuestion = questionEl.textContent.trim();
    const originalAnswer = answerEl.textContent.trim();


    if (updatedQuestion === "" || updatedAnswer === "") {
        alert("Please complete both question and answer before submitting.");
        return;
    }

    if (updatedQuestion === originalQuestion && updatedAnswer === originalAnswer) {
      alert("Please modify the question or answer before submitting.");
      return;
   }

    const formData = new FormData();
    formData.append("flashcard_id", flashcardId);
    formData.append("question", updatedQuestion);
    formData.append("answer", updatedAnswer);

    const resultContainer = document.createElement("div");
    resultContainer.classList.add("ai-result-message");
    resultContainer.innerHTML = `<p>⏳ Reviewing your flashcard with AI...</p>`;
    document.body.appendChild(resultContainer);

    fetch("../../controllers/modifyFlashcard.php", {  
        method: "POST",
        body: formData,
    })
    .then((response) => response.text())
        .then((response) => {
            resultContainer.remove();

            try {
                const result = JSON.parse(response);

                if (result.success) {
                    const feedback = result.feedback;
                    const status = result.status;

                    if (status === "approved") {
                        alert(
                            "✅ Your flashcard is approved by AI!\n\n" +
                                feedback +
                                "\n\nNow waiting for final review by your doctor."
                        );
                    } else {
                        alert(
                            "❌ Your flashcard was rejected by AI.\n\n" +
                                feedback +
                                "\n\nYou can edit and try again."
                        );
                      
                    }

                    window.location.href = "followFlashcards.php";
                } else {
                    alert("Failed to add flashcard: " + result.message);
                }
            } catch (e) {
                console.error("Unexpected response:", response);
                alert("Error reviewing flashcard. Please try again.");
            }
        })
        .catch((err) => {
            resultContainer.remove();
            console.error("Error adding flashcard:", err);
            alert("Something went wrong while submitting.");
        });
});

      fetchFlashcards();


     
  </script>

</body>
</html>
