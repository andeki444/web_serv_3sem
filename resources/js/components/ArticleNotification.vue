<template>
    <div v-if="article" class="article-notification" role="alert" aria-live="polite">
        <span>Добавлена новая статья: <a :href="`/articles/${article.id}`">{{ article.name }}</a></span>
        <button type="button" aria-label="Закрыть уведомление" @click="article = null">×</button>
    </div>
</template>

<script>
export default {
    data() {
        return { article: null };
    },
    mounted() {
        window.Echo?.channel('articles').listen('NewArticleEvent', (event) => {
            this.article = event.article;
        });
    },
    beforeUnmount() {
        window.Echo?.leave('articles');
    },
};
</script>

<style scoped>
.article-notification {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1000;
    display: flex;
    gap: 1rem;
    align-items: center;
    max-width: min(30rem, calc(100vw - 2rem));
    padding: 1rem;
    border: 1px solid #86b7fe;
    border-radius: .5rem;
    background: #e7f1ff;
    box-shadow: 0 4px 16px #0002;
}
a { color: #0752a3; font-weight: bold; }
button { border: 0; background: transparent; font-size: 1.5rem; cursor: pointer; }
</style>
