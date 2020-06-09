import React, { useEffect, useState } from 'react';

import DatePicker from 'react-datepicker';
import pt from 'date-fns/locale/pt';

import { MdChevronLeft } from "react-icons/all";

import api from '~/services/api';

import { Container } from "../styles";
import { Content, Time } from "./styles";

const SelectDateTime = ({ page, setPage }) => {
  const [date, setDate] = useState(new Date());
  const [hours, setHours] = useState([]);

  useEffect(() => {
    async function loadDateTime() {
      const response = await api.get(`providers/${page.state.provider.id}/available`, {
        params: {
          date: date.getTime()
        }
      });
      setHours(response.data);
    }
    loadDateTime();
  }, [date]);

  function handleClick(dateTime) {
    setPage(page => ({ number: 2, state: { ...page.state, dateTime } }));
  }

  return (
    <Container>
      <button type='button' onClick={ () => setPage({ number: 0, state: {} }) }>
        <MdChevronLeft size={ 48 } color='#ffffff'/>
      </button>
      <Content>
        <div className='date-picker-container'>
          <DatePicker
            className='date-picker'
            selected={ date }
            onChange={ setDate }
            minDate={ new Date() }
            locale={ pt }
          />
        </div>
        <ul>
          { hours.map(hour => (
            <Time
              key={ hour.time }
              onClick={ hour.available ? () => handleClick(hour.value) : null }
              past={ !hour.available }
            >
              <p>{ hour.time }</p>
            </Time>
          )) }
        </ul>
      </Content>
      <button/>
    </Container>
  );
};

export default SelectDateTime;
