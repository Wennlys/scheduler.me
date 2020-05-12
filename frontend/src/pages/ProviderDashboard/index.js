import React, { useState, useMemo, useEffect } from 'react'
import { format, subDays, addDays, setHours, setMinutes, setSeconds, isBefore, isEqual, parseISO } from 'date-fns';
import pt from 'date-fns/locale/pt';
import { MdChevronLeft, MdChevronRight } from 'react-icons/all'

import api from '~/services/api';

import { Container, Time } from './styles'

const range = [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19];

const ProviderDashboard = () => {
  const [schedule, setSchedule] = useState([]);
  let [date, setDate] = useState(new Date());

  const dateFormatted = useMemo(
    () => format(date, "d 'de' MMMM", { locale: pt }),
    [date]
  );

  useEffect(() => {
    async function loadSchedule() {
      const response = await api.get('schedule', {
        params: { date: format(date, "yyyy-MM-dd HH:mm:ss") }
      });

      const data = range.map(hour => {
        const formatedDate = setSeconds(setMinutes(setHours(date, hour), 0), 0);

        return {
          time: `${ hour }:00h`,
          past: isBefore(formatedDate, new Date()),
          appointment: response.data ? response.data.find(a =>
            isEqual(parseISO(a.date), formatedDate)
          ) : null
        };
      });

      setSchedule(data);
    }

    loadSchedule();
  }, [date]);

  function handlePrev() {
    setDate(subDays(date, 1));
  }

  function handleNext() {
    setDate(addDays(date, 1));
  }

  return (
    <Container>
      <header>
        <button type='button' onClick={ handlePrev }>
          <MdChevronLeft size={ 36 } color='#ffffff'/>
        </button>
        <strong>{ dateFormatted }</strong>
        <button type='button' onClick={ handleNext }>
          <MdChevronRight size={ 36 } color='#ffffff'/>
        </button>
      </header>

      <ul>
        { schedule.map(time => (
          <Time key={ time.time } past={ time.past } available={ !time.appointment }>
            <strong>{ time.time }</strong>
            <span>{ time.appointment ? time.appointment.user.name : "Disponível" }</span>
          </Time>
        )) }
      </ul>
    </Container>
  );
}

export default ProviderDashboard
