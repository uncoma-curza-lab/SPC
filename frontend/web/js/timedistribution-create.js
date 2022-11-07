const LIST = 'field-timedistributioncreationform-lesson_type'
const usedHours = 'used-hours'
const availableHours = 'available-hours'
const courseTotalHours = 'course-total-hours'
const API_ERROR = 'spc_api_error'

document.addEventListener("DOMContentLoaded", function(event) { 
    let totalHours = 0
    let courseTotalHourWeek = 0
    
    $('#programa-asignatura_id').select2().on('change', (e) => {
        const courseId = $('#programa-asignatura_id').val()
        console.log('fetching...', `${SPC_URL_API}/v1/asignatura/${courseId}`)
        fetch(`${SPC_URL_API}/v1/asignatura/${courseId}`)
            .then((response) => response.json())
            .then(result => {
                console.log('retrieve', result)
                courseTotalHourWeek = result.carga_sem
                $(`#${courseTotalHours}`).html(`Carga total de la semana: ${courseTotalHourWeek}`)
            })
            .catch(() => {
                $(`#${API_ERROR}`).html('Ocurrió un error al obtener la información de la asignatura')
                await.delay(100)
                $(`#${API_ERROR}`).html('')
            })
    })

    let availableHoursShowElement = $(`#${availableHours}`)
    let usedHoursShowElement = $(`#${usedHours}`)

    usedHoursShowElement.html(totalHours) 

    function recalculateHours() {
        totalHours = 0
        $(`.${LIST}`).find('input[type=number]').get().map((item, algo) => {
            totalHours += parseFloat(item.value)
        })

        usedHoursShowElement.html(totalHours) 

    }

    $(`.${LIST}`).on('change', (e) => {
        recalculateHours()

        //$(`.${LIST}`).find('tbody.tr.multiple-input-list__item').map((item) => console.log(item))
    })

    $(`.${LIST}`).on('afterAddRow', (e, row, currentIndex) => {
    })

    $(`.${LIST}`).on('afterDeleteRow', (e, row, currentIndex) => {
        recalculateHours()
    })
})

