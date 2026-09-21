export type ModalMessageType =
    | 'info'
    | 'warning'
    | 'error'
    | 'medical'

export interface ModalMessage {
    type: ModalMessageType
    title: string
    message: string
}

export const useModalMessage = () => {
    const modalMessage = useState<ModalMessage | null>(
        'modal-message',
        () => null
    )

    const showModalMessage = (
        type: ModalMessageType,
        title: string,
        message: string
    ) => {
        modalMessage.value = {
            type,
            title,
            message,
        }
    }

    const clearModalMessage = () => {
        modalMessage.value = null
    }

    return {
        modalMessage,
        showModalMessage,
        clearModalMessage,
    }
}