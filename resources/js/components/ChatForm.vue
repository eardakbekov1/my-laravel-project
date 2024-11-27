<template>
    <!-- Display an input field and a send button -->
    <div class="input-group">
        <!-- Input field -->
        <input
            id="btn-input"
            type="text"
            name="message"
            class="form-control input-sm"
            placeholder="Type your message here..."
            v-model="newMessage"
            @keyup.enter="sendMessage" <!-- Call sendMessage() when the Enter key is pressed -->
        />
        <!-- Button -->
        <span class="input-group-btn">
      <button
          class="btn btn-primary btn-sm"
          id="btn-chat"
          @click="sendMessage" <!-- Call sendMessage() when this button is clicked -->
      >
        Send
            </button>
    </span>
    </div>
</template>

<script>
export default {
    // Takes the "user" prop from <chat-form> … :user="{{ Auth::user() }}"></chat-form> in the parent chat.blade.php.
    props: ["user"],
    data() {
        return {
            newMessage: "",
        };
    },
    methods: {
        sendMessage() {
            // Emit a "messagesent" event including the user who sent the message along with the message content
            this.$emit("messagesent", {
                user: this.user,
                message: this.newMessage, // newMessage is bound to the earlier "btn-input" input field
            });
            // Clear the input
            this.newMessage = "";
        },
    },
};
</script>
