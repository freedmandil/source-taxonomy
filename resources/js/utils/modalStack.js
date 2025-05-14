// src/utils/modalStack.js
import { ref } from 'vue'

const stackCount = ref(0)

export function useModalStack() {
    function push() {
        stackCount.value += 1
        return stackCount.value
    }

    function pop() {
        stackCount.value = Math.max(stackCount.value - 1, 0)
        return stackCount.value
    }

    return { stackCount, push, pop }
}
