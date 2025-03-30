const sendChatbotMessage = async () => {
    const input = document.getElementById('chatbot-input');
    const messages = document.getElementById('chatbot-messages');

    if (!input.value.trim()) return;

    // Hiển thị tin nhắn người dùng
    messages.innerHTML += `<div class="user-message">${input.value}</div>`;

    try {
        const response = await fetch('http://127.0.0.1:8000/api/chatbot/ask', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ question: input.value }),
        });

        const data = await response.json();

        // Hiển thị phản hồi từ chatbot
        messages.innerHTML += `<div class="bot-message">${data.reply}</div>`;
    } catch (error) {
        console.error('Lỗi khi gọi API:', error);
        messages.innerHTML += `<div class="bot-message error">Chatbot không hoạt động.</div>`;
    }

    input.value = ''; // Xóa input sau khi gửi
};
