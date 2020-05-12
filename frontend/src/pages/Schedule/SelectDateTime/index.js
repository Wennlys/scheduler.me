import React, { useEffect, useState } from 'react';

import { MdChevronLeft } from "react-icons/all";

import api from '~/services/api';

import { Container } from "../styles";
import { Content } from "./styles";

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
      {/*<DateTimePicker />*/ }
      <button type='button' onClick={ () => setPage({ number: 0, state: {} }) }>
        <MdChevronLeft size={ 48 } color='#ffffff'/>
      </button>
      <Content>
        <ul>
          { hours.map(hour => (
            <li key={ hour.time } onClick={ () => handleClick(hour.value) }>
              <p>{ hour.value }</p>
            </li>
          )) }
        </ul>
      </Content>
      <button/>
    </Container>
  );
};

export default SelectDateTime;
