<template>
    <div class="error">
        <h1>403</h1>
        <p>Acess denied to requested page</p>
        <v-btn
            rounded="lg"
            color="secondary"
            size="small"
            link
            to="/dashboard"
            >
            Return Home
        </v-btn>
    </div>
</template>

<style scoped>
.error {
    text-align: center;
    margin-top: 4%;
}
.error h1 {
    font-size: 2rem;
    font-weight: 900;
    letter-spacing: 0.4rem;
    background: -webkit-linear-gradient(#666, black);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.error p {
    font-size: 1.1rem;
    letter-spacing: 0.1rem;
    padding: 0px 0px 8px 0px;
}
</style>