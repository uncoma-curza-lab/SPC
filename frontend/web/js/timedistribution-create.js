const LIST = 'field-timedistributioncreationform-lesson_type'
const usedHours = 'used-hours'
const availableHours = 'available-hours'
const courseTotalHours = 'course-total-hours'
const API_ERROR = 'spc_api_error'
const SAVE_BUTTON = 'save-button'
const SECTION_DISTRIBUTE_SCHEMA = 'time-distribution-schema'


document.addEventListener("DOMContentLoaded", function(event) { 
    let totalHours = 0
    let courseTotalHourWeek = 0
    let availableHoursShowElement = $(`#${availableHours}`)
    let usedHoursShowElement = $(`#${usedHours}`)
    let sectionElement = $(`#${SECTION_DISTRIBUTE_SCHEMA}`)
    const saveButton = $(`#${SAVE_BUTTON}`) 
    const multipleRowList = $(`.${LIST}`)

    sectionElement.hide()

    usedHoursShowElement.html(totalHours) 
    
    $('#programa-asignatura_id').select2().on('change', (e) => {
        const courseId = $('#programa-asignatura_id').val()
        fetch(`${SPC_URL_API}/v1/asignatura/${courseId}`)
            .then((response) => (response.ok) ? response.json() : showError())
            .then(result => {
                multipleRowList.multipleInput('clear')
                courseTotalHourWeek = result.carga_sem
                $(`#${courseTotalHours}`).html(`Carga total de la semana: ${courseTotalHourWeek}`)
                recalculateHours()
                sectionElement.show()
            })
            .catch(() => {
                showError()
            })
    })

    const showError = () => {
        $(`#${API_ERROR}`).html('Ocurrió un error al obtener la información de la asignatura')
        setTimeout(() => {
            $(`#${API_ERROR}`).html('')
        }, 3000)
        sectionElement.hide()
    }

    const recalculateHours = () => {
        totalHours = 0
        multipleRowList.find('.list-cell__leson_type_hours input[type=number]').get().map((item, algo) => {
            totalHours += parseFloat(item.value)
        })

        usedHoursShowElement.html(totalHours) 
        availableHoursShowElement.html(courseTotalHourWeek - totalHours)

        if ((courseTotalHourWeek - totalHours) < 0) {
            saveButton.prop('disabled', true)
        } else {
            saveButton.prop('disabled', false)
        }


    }

    const getMaxHourPerLessonType = (row) => {

        const selectLessonType = row.find('.list-cell__leson_type select').first()
        let lessonTypeID = selectLessonType.val()
        let maxUsePercentage = 100
        if (!isNaN(lessonTypeID)) {
            maxUsePercentage = maxPercentageByLessonType[lessonTypeID]
        }

        return maxUsePercentage
    }

    const determineMaxHourPerLessonType = (row) => {
        let maxUsePercentage = getMaxHourPerLessonType(row)

        row.find('.list-cell__leson_type_max_percentage input[type=number]')
            .first()
            .val(courseTotalHourWeek * maxUsePercentage / 100)
    }

    multipleRowList.on('afterAddRow', (e, row, currentIndex) => {
        const selectLessonType = row.find('.list-cell__leson_type select').first()
        const cantHoursRow = row.find('.list-cell__leson_type_hours input[type=number]').first()
        determineMaxHourPerLessonType(row)
        selectLessonType.on('change', () => {
            determineMaxHourPerLessonType(row)
        })
        cantHoursRow.on('change', () => {
            recalculateHours()
            let maxUsePercentage =  getMaxHourPerLessonType(row)
            if (parseFloat(cantHoursRow.val()) > (courseTotalHourWeek * maxUsePercentage / 100)) {
                saveButton.prop('disabled', true)
            }
            console.log(parseFloat(cantHoursRow.val()) > (courseTotalHourWeek * maxUsePercentage / 100), parseFloat(cantHoursRow.val()), (courseTotalHourWeek * maxUsePercentage / 100))
        })

    })

    multipleRowList.on('afterDeleteRow', (e, row, currentIndex) => {
        recalculateHours()
    })
})

