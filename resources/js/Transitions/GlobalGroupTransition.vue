<script>
// JavaScript hooks logic...
</script>

<template>
  <!-- wrap the built-in Transition component -->
  <TransitionGroup>
    <slot></slot> <!-- pass down slot content -->
  </TransitionGroup>
</template>

<style>
/* we will explain what these classes do next! */
.v-enter-active,
.v-leave-active {
  transition: opacity 2s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>