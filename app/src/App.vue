<script setup>
import TaskList from '@/components/TaskList.vue';
import AddTask from '@/components/AddTask.vue';
</script>

<template>
  <div>
    <h1 class="titulo">TO DO LIST</h1>
    <AddTask />
    <TaskList />
  </div>
</template>

<style>
.titulo {
  text-transform: uppercase;
  margin: 0;
  padding: 20px 0;
  font-size: 5em;
  border-bottom: 2px solid #000;
  display: inline-block;
}

</style>
