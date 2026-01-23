<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<!-- Floating Chat Button with AI Chatbot Icon -->
<button id="chatbot-btn" title="How can i help you" data-toggle="modal" data-target="#chatbot-modal">
    <i class="fa fa-robot"></i>
</button>


<!-- Chat Modal -->
<div class="modal fade" id="chatbot-modal" tabindex="-1" role="dialog" aria-labelledby="chatbotLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="chatbotLabel">Doomshell AI Chat</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="chat-messages" class="chat-box">
                    <!-- set here default message good lookin  -->
                    <div class="message">
                        <p>Hi, how can I help you today?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- make this div col  -->
                <div class="col-md-10">
                    <input type="text" id="user-input" class="form-control" placeholder="Type your message..." onkeypress="handleKeyPress(event)">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" id="send-btn" onclick="sendMessage()">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Floating Chat Button */
    #chatbot-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease-in-out;
    }

    #chatbot-btn:hover {
        transform: scale(1.1);
    }

    /* Chat Modal Header */
    .modal-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    /* Chat Box */
    .chat-box {
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        background: #f0f2f5;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
    }

    /* Chat Message Styles */
    .chat-message {
        max-width: 80%;
        padding: 10px 15px;
        border-radius: 18px;
        margin: 5px 0;
        font-size: 14px;
        display: inline-block;
        opacity: 0;
        animation: fadeIn 0.5s forwards;
    }

    /* User Message */
    .user-message {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        align-self: flex-end;
        text-align: right;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    /* Bot Message */
    .bot-message {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
        align-self: flex-start;
        text-align: left;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    /* Input & Send Button */
    /* .modal-footer {
        display: flex;
        gap: 8px;
    } */

    .modal-footer input {
        flex: 1;
        border-radius: 20px;
        padding: 10px;
        border: 1px solid #ccc;
    }

    .modal-footer button {
        border-radius: 20px;
        padding: 8px 20px;
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
        color: white;
        cursor: pointer;
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    let chatHistory = [];

    // function openChat() {
    //     $('#chatbot-modal').modal('show');
    // }

    function loadChatHistory() {
        const chatBox = document.getElementById("chat-messages");
        chatBox.innerHTML = chatHistory.map(chat =>
            `<div class="chat-message ${chat.role === 'You' ? 'user-message' : 'bot-message'}">
                <b>${chat.role}:</b> ${chat.text}
            </div>`).join('');
        chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll
    }

    function handleKeyPress(event) {
        if (event.key === "Enter") {
            sendMessage();
        }
    }

    async function sendMessage() {
        const userInput = document.getElementById("user-input").value;
        if (!userInput.trim()) return;

        chatHistory.push({
            role: "You",
            text: userInput
        });
        loadChatHistory();
        document.getElementById("user-input").value = "";

        const apiKey = "AIzaSyD4SwdwuCsU-sXxs1fPh_7ET_Dasa7DACI"; // Replace with your API key
        const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`;
        const requestBody = {
            contents: [{
                role: "user",
                parts: [{
                    text: `Only answer about Doomshell Software. 
            
            **ABOUT DOOMSHELL SOFTWARE**  
            Doomshell has developed many challenging projects successfully through the expertise of its workforce and we have realized that web application design and development should not have to be expensive. Outsourcing will cut your expenses by more than 50%. Outsource projects and save a lot of money. Outsourcing is hiring an outside organization to perform services such as information processing and application development. We provide a safe escrow environment and you don't release full money until the project is completed.

            Doomshell with its latest technology always keeps a keen eye on the latest mobile apps development in the industry and our technology experts are always busy updating our partners/client's technological tools making them fully compatible with the latest changes in technology.

            Founded in [2010], Doomshell Software has grown into a trusted technology partner for clients worldwide. Our expertise spans across industries, including e-commerce, healthcare, real estate, education, and finance, delivering robust and scalable solutions tailored to meet unique business needs.  

            Our mission is to empower businesses with technology-driven solutions that enhance productivity, efficiency, and growth. We take pride in our customer-centric approach, ensuring top-notch service and unparalleled quality in every project we undertake.  

            **OUR EXPERTISE**  
            - Custom Software Development  
            - Web & Mobile App Development (Android & iOS)  
            - UI/UX Design & Branding  
            - E-commerce Solutions  
            - Cloud Computing & DevOps  
            - AI & Machine Learning Integration  
            - Digital Marketing & SEO  

            <strong>OUR TEAM</strong>  
            - **Vikas Solanki** – Founder & CEO  
            - **Gajanand Kumawat** – Project Management Lead  
            - **Rupam Singh** – Full Stack Developer  
            - **Sanjay Beniwal** – DevOps Engineer  
            - **Rohit Raj** – Digital Growth & Strategy Lead  
            - **Rajesh (Bhagwan)** – AI Engineer  
  

            At Doomshell Software, we believe in collaboration, creativity, and continuous learning to stay ahead in the ever-evolving tech landscape.  

            **WHY CHOOSE US?**  
            ✅ Innovative & Scalable Solutions  
            ✅ Experienced & Skilled Team  
            ✅ Agile Development Process  
            ✅ Client-Centric Approach  
            ✅ 24/7 Support & Maintenance 
            
            🌐 <strong>Website:</strong> <a href="https://www.doomshell.com/" target="_blank">www.doomshell.com</a>  
            📩 <strong>Email:</strong> <a href="mailto:contact@doomshell.com">contact@doomshell.com</a>  
            💬 <strong>Hangout:</strong> [Chat with Us](mailto:contact@doomshell.com)  
            📞 <strong>Call Us:</strong> <a href="tel:+918005523567">+91 8005523567</a>  

            Join hands with Doomshell Software and let’s build the future together! 🚀  

            User: ${userInput}`
                }]
            }],
            generationConfig: {
                temperature: 1,
                topP: 0.95,
                topK: 40,
                maxOutputTokens: 512
            }
        };
        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(requestBody),
        });

        const data = await response.json();
        const botReply = data.candidates?.[0]?.content?.parts?.[0]?.text || "I can only answer about Doomshell Software.";

        chatHistory.push({
            role: "Bot",
            text: botReply
        });
        loadChatHistory();
    }
</script>