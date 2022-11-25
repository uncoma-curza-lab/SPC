const LIST = 'field-timedistributioncreationform-lesson_type'
const usedHours = 'used-hours'
const availableHours = 'available-hours'
const courseTotalHours = 'course-total-hours'
const ERROR = 'js-error'
const SAVE_BUTTON = 'btn'
const SECTION_DISTRIBUTE_SCHEMA = 'time-distribution-schema'

window.addEventListener("DOMContentLoaded", function(event) { 
    let totalHours = 0
    let availableHoursShowElement = $(`#${availableHours}`)
    let usedHoursShowElement = $(`#${usedHours}`)
    let sectionElement = $(`#${SECTION_DISTRIBUTE_SCHEMA}`)
    const saveButton = $(`.${SAVE_BUTTON}`) 

    usedHoursShowElement.html(totalHours) 
    
    const showError = (message) => {
        $(`#${ERROR}`).html(message)
        setTimeout(() => {
            $(`#${ERROR}`).html('')
        }, 3000)
        //sectionElement.hide()
    }

    const recalculateHours = () => {
        totalHours = 0
        sectionElement.find('.hours').get().map((item,) => {
            if (!isNaN(parseFloat(item.value))) {
                totalHours += parseFloat(item.value)
            }
        })

        usedHoursShowElement.html(totalHours.toFixed(2)) 
        availableHoursShowElement.html((courseTotalHourWeek - totalHours).toFixed(2))

        return totalHours
    }


    const getMaxHourPerLessonType = (row) => {
        const selectLessonType = row.find('.max_percentage').first()
        let maxPercentageFromLabel = selectLessonType.text()
        let maxUsePercentage = 100
        if (!isNaN(maxPercentageFromLabel)) {
            maxUsePercentage = parseInt(maxPercentageFromLabel)
        }

        return maxUsePercentage
    }

    const determineMaxHourPerLessonType = (row) => {
        let maxUsePercentage = getMaxHourPerLessonType(row)

        row.find('.max_hours')
            .first()
            .val(courseTotalHourWeek * maxUsePercentage / 100)
    }

    const runValidationsAndSetButton = () => {
        const availableHoursZero = courseTotalHourWeek - recalculateHours()
        if (availableHoursZero < 0) {
            showError('Verifique la cantidad de horas')
        }
        if (!validateAllPercentages()) {
            showError('Verifique el máximo de horas')
            saveButton.prop('disabled', true)
            return;
        }
        if ((availableHoursZero) != 0) {
            saveButton.prop('disabled', true)
            return;
        }

        saveButton.prop('disabled', false)
    }

    const validateAllPercentages = () => {

        const rows = sectionElement.find('.distribution-specification').get()
        const result = rows.some((rowElement) => {
            const row = $(rowElement)
            let maxUsePercentage =  getMaxHourPerLessonType(row)
            const cantHoursRow = row.find('.hours').first()
            if (parseFloat(cantHoursRow.val()) > (courseTotalHourWeek * maxUsePercentage / 100)) {
                return true
            }
        })

        return !result
    }

    recalculateHours()

    sectionElement.find('.distribution-specification .hours').each((index,element) => {
        $(element).on('change',(e) => {
            const row = $(e.currentTarget).parent().parent().siblings()
            determineMaxHourPerLessonType(row)
            runValidationsAndSetButton()
        })
        const row = $(element).parent().parent().siblings()
        determineMaxHourPerLessonType(row)
    })
})

