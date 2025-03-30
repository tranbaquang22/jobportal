<div class="chatbot-container">
    <input type="text" id="chatbot-input" placeholder="Nhập câu hỏi..." class="chatbot-input">
    <button onclick="askChatbot()" class="chatbot-btn">Trả lời</button>
    <p id="chatbot-reply">Chatbot: </p>
</div>

<script>
    async function askChatbot() {
        const question = document.getElementById("chatbot-input").value;
        const response = await fetch("{{ url('/api/chatbot') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ question }),
        });

        const data = await response.json();
        document.getElementById("chatbot-reply").innerText = "Chatbot: " + data.reply;
    }
</script>

<style>
    .chatbot-container {
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        width: 300px;
        background-color: #f9f9f9;
        border-radius: 10px;
    }
    .chatbot-input {
        width: 80%;
        padding: 5px;
    }
    .chatbot-btn {
        padding: 5px 10px;
        cursor: pointer;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
    }
</style>
