<!-- 
    Chatbot Widget Component
    Widget chat yang muncul di pojok kanan bawah
    Menggunakan Tailwind CSS dan Alpine.js
-->
<div x-data="chatbot()" x-init="init()" class="fixed md:bottom-6 md:right-6 bottom-0 right-0 z-50">
    <!-- Chat Button -->
    <button 
        @click="toggleChat()" 
        x-show="!isOpen"
        x-cloak
        class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full p-3 md:p-4 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center m-4 md:m-0"
        style="display: none;"
        aria-label="Open Chat"
    >
        <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <!-- Notification Badge -->
        <span x-show="hasNewMessage" class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full animate-pulse"></span>
    </button>

    <!-- Chat Window -->
    <div 
        x-show="isOpen" 
        x-cloak
        class="bg-white md:rounded-2xl shadow-xl w-full md:w-96 h-screen md:h-[600px] flex flex-col overflow-hidden"
        style="display: none;"
    >
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-3 md:p-4 flex items-center justify-between">
            <div class="flex items-center space-x-2 md:space-x-3">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h3 class="font-semibold text-base md:text-lg truncate">Asisten Virtual</h3>
                    <p class="text-xs text-blue-100 truncate">SMK Bina Mandiri Bekasi</p>
                </div>
            </div>
            <button @click="toggleChat()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Messages Container -->
        <div 
            x-ref="messagesContainer"
            class="flex-1 overflow-y-auto p-3 md:p-4 space-y-3 md:space-y-4 bg-gray-50"
            style="scroll-behavior: smooth;"
        >
            <!-- Welcome Message -->
            <div class="flex items-start space-x-2">
                <div class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none p-2.5 md:p-3 shadow-sm max-w-[75%] md:max-w-[80%]">
                    <p class="text-xs md:text-sm text-gray-800">Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi. Ada yang bisa saya bantu?</p>
                </div>
            </div>

            <!-- Messages Loop -->
            <template x-for="(message, index) in messages" :key="index">
                <div>
                    <!-- User Message -->
                    <div x-show="message.type === 'user'" class="flex items-start space-x-2 justify-end">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-2xl rounded-tr-none p-2.5 md:p-3 shadow-sm max-w-[75%] md:max-w-[80%]">
                            <p class="text-xs md:text-sm break-words" x-text="message.text"></p>
                        </div>
                        <div class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Bot Message -->
                    <div x-show="message.type === 'bot'" class="flex items-start space-x-2">
                        <div class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="bg-white rounded-2xl rounded-tl-none p-2.5 md:p-3 shadow-sm max-w-[75%] md:max-w-[80%]">
                            <p class="text-xs md:text-sm text-gray-800 whitespace-pre-line break-words" x-html="formatMessage(message.text)"></p>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex items-start space-x-2">
                <div class="flex-shrink-0 w-7 h-7 md:w-8 md:h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none p-2.5 md:p-3 shadow-sm">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 md:p-4 bg-white border-t border-gray-200 safe-area-bottom">
            <form @submit.prevent="sendMessage" class="flex items-center space-x-2">
                <input 
                    x-model="userInput"
                    @keydown.enter.prevent="sendMessage"
                    type="text" 
                    placeholder="Ketik pesan Anda..."
                    class="flex-1 px-3 md:px-4 py-2 md:py-3 text-sm md:text-base border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    :disabled="isTyping"
                >
                <button 
                    type="button"
                    @click="sendMessage"
                    :disabled="!userInput.trim() || isTyping"
                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-2.5 md:p-3 rounded-xl hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
            <p class="text-xs text-gray-500 mt-2 text-center hidden md:block">Powered by SMK Bina Mandiri Bekasi</p>
        </div>
    </div>
</div>

<script>
function chatbot() {
    return {
        isOpen: false,
        isTyping: false,
        hasNewMessage: false,
        userInput: '',
        messages: [],
        sessionId: null,

        init() {
            // Generate session ID baru setiap kali (tidak disimpan)
            this.sessionId = this.generateSessionId();
            
            // Tidak load messages dari localStorage
            // Chat akan selalu dimulai dari awal
        },

        generateSessionId() {
            return 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            this.hasNewMessage = false;
            
            if (this.isOpen) {
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            }
        },

        async sendMessage() {
            if (!this.userInput.trim()) return;

            const message = this.userInput.trim();
            this.userInput = '';

            // Tambahkan pesan user
            this.messages.push({
                type: 'user',
                text: message,
                timestamp: new Date()
            });

            this.scrollToBottom();
            this.isTyping = true;

            try {
                // Kirim ke server
                const response = await fetch('{{ route("chatbot.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: message,
                        session_id: this.sessionId
                    })
                });

                const data = await response.json();

                // Simulasi delay untuk efek natural
                await new Promise(resolve => setTimeout(resolve, 500));

                // Tambahkan balasan bot
                this.messages.push({
                    type: 'bot',
                    text: data.message,
                    timestamp: new Date()
                });

                // Tidak simpan ke localStorage
                // Chat akan hilang saat refresh

                // Jika chat tertutup, tampilkan notifikasi
                if (!this.isOpen) {
                    this.hasNewMessage = true;
                }

            } catch (error) {
                console.error('Error:', error);
                this.messages.push({
                    type: 'bot',
                    text: 'Maaf, terjadi kesalahan. Silakan coba lagi. 😅',
                    timestamp: new Date()
                });
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        formatMessage(text) {
            // Format text dengan bold untuk **text**
            text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            
            // Format emoji
            text = text.replace(/:\)/g, '😊');
            text = text.replace(/:\(/g, '😢');
            
            return text;
        }
    }
}
</script>

<style>
/* Prevent flash of unstyled content */
[x-cloak] {
    display: none !important;
}

/* Custom scrollbar untuk chat */
[x-ref="messagesContainer"]::-webkit-scrollbar {
    width: 6px;
}

[x-ref="messagesContainer"]::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

[x-ref="messagesContainer"]::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 10px;
}

[x-ref="messagesContainer"]::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

/* Animation untuk typing indicator */
@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

.animate-bounce {
    animation: bounce 1s infinite;
}
</style>
