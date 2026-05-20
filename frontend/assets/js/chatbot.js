/* Saksham Bharti Chatbot Logic */

document.addEventListener('DOMContentLoaded', () => {
    const chatbotHTML = `
        <div class="chatbot-container">
            <div class="chat-window" id="chatWindow">
                <div class="chat-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-robot me-2"></i>
                        <h6>Saksham Assistant</h6>
                    </div>
                    <button class="btn btn-link text-white p-0" id="closeChat"><i class="fas fa-times"></i></button>
                </div>
                <div class="chat-messages" id="chatMessages">
                    <div class="message bot">
                        Hello! I am Saksham Assistant. How can I help you today?
                        <div class="quick-replies">
                            <div class="quick-reply" onclick="botResponse('What programs do you offer?')">Our Programs</div>
                            <div class="quick-reply" onclick="botResponse('How can I donate?')">Donations</div>
                            <div class="quick-reply" onclick="botResponse('Tell me about scholarships')">Scholarships</div>
                            <div class="quick-reply" onclick="botResponse('Where are you located?')">Location</div>
                        </div>
                    </div>
                </div>
                <div class="chat-input-area">
                    <input type="text" id="userInput" placeholder="Type a message...">
                    <button id="sendMessage"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
            <div class="chat-bubble" id="chatBubble">
                <i class="fas fa-comment-dots"></i>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', chatbotHTML);

    const chatBubble = document.getElementById('chatBubble');
    const chatWindow = document.getElementById('chatWindow');
    const closeChat = document.getElementById('closeChat');
    const userInput = document.getElementById('userInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatMessages = document.getElementById('chatMessages');

    chatBubble.addEventListener('click', () => {
        chatWindow.style.display = chatWindow.style.display === 'flex' ? 'none' : 'flex';
        if (chatWindow.style.display === 'flex') {
            userInput.focus();
        }
    });

    closeChat.addEventListener('click', () => {
        chatWindow.style.display = 'none';
    });

    let isLeadCapture = false;
    let leadData = { name: '', contact: '', message: '' };

    const addMessage = (text, sender) => {
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${sender}`;
        msgDiv.innerHTML = text;
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    };

    window.botResponse = (text) => {
        addMessage(text, 'user');
        
        setTimeout(() => {
            let response = "";
            const input = text.toLowerCase().trim();

            if (isLeadCapture) {
                leadData.contact = text;
                // Send to server
                fetch('save_chat_inquiry.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(leadData)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        addMessage("Thank you! I've shared your details with our team. They will reach out to you shortly at: " + text, 'bot');
                    } else {
                        addMessage("Oops! I had trouble saving your details. Please contact us at info@sakshambharti.org directly.", 'bot');
                    }
                    isLeadCapture = false;
                });
                return;
            }

            if (input.includes('refund') || input.includes('money back') || input.includes('return my money')) {
                response = "We understand your concern. For any donation-related issues or refund requests, please email us at <b>finance@sakshambharti.org</b> or call our office directly at +91 98765 43210. Our team will assist you immediately.";
            } else if (input.includes('program') || input.includes('course') || input.includes('training')) {
                response = "We offer professional training in IT (Basic to Advanced), Beauty Culture, Tailoring & Fashion Design, and more. Our goal is to make youth self-reliant!";
            } else if (input.includes('donate') || input.includes('money') || input.includes('help')) {
                response = "Thank you for your interest in supporting us! You can find all donation options on our <a href='get-involved.php'>Get Involved</a> page. Every contribution empowers a life.";
            } else if (input.includes('scholarship') || input.includes('uthaan')) {
                response = "Our 'Uthaan' scholarship program supports meritorious students from economically weaker sections. You can find details on our <a href='programs.php'>Programs</a> page.";
            } else if (input.includes('location') || input.includes('center') || input.includes('where') || input.includes('nangloi')) {
                response = "We have multiple centers including our headquarters and the new center at Nangloi. Check our <a href='contact.php'>Contact Us</a> page for full addresses.";
            } else if (input.includes('impact') || input.includes('success') || input.includes('reach')) {
                response = "Saksham Bharti has trained over 25,000+ youth and helped 5,000+ individuals secure stable jobs. Check our <a href='impact.php'>Impact</a> page for more details!";
            } else if (input.includes('volunteer') || input.includes('join')) {
                response = "We love having volunteers! Please sign up on our <a href='volunteer.php'>Volunteer Page</a> and we will reach out to you.";
            } else if (input === 'hi' || input === 'hello' || input === 'hey') {
                response = "Hi there! How can Saksham Bharti help you today?";
            } else if (input.includes('thank') || input === 'thanks') {
                response = "You're very welcome! Is there anything else I can assist you with?";
            } else if (input === 'ok' || input === 'okay' || input === 'sure' || input === 'yes') {
                response = "Great! Let me know if you have any questions about our work or how to get involved.";
            } else if (input.includes('bye') || input.includes('done') || input === 'no thanks') {
                response = "Goodbye! Have a wonderful day and thank you for visiting Saksham Bharti.";
            } else if (input.includes('contact') || input.includes('phone') || input.includes('email')) {
                response = "You can reach us at info@sakshambharti.org or call us at +91 98765 43210. We'd love to hear from you!";
            } else {
                response = "I'm still learning! Would you like me to notify our team so they can contact you directly? <br><br><b>Please type your Name and Phone/Email below:</b>";
                isLeadCapture = true;
                leadData.message = text; // Save what they were asking about
            }

            if (response) addMessage(response, 'bot');
        }, 800);
    };

    sendMessage.addEventListener('click', () => {
        const text = userInput.value.trim();
        if (text) {
            botResponse(text);
            userInput.value = '';
        }
    });

    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage.click();
        }
    });
});
