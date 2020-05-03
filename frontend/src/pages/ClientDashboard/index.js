import React, { useEffect, useState } from 'react'
import { formatRelative } from "date-fns";
import pt from "date-fns/locale/pt";

import api from '~/services/api';

import { Container, Appointment } from './styles'

import remove from '~/assets/delete.svg';

const ClientDashboard = () => {
  const [date, setDate] = useState([]);
  const [trigger, setTrigger] = useState(false);
  const [appointments, setAppointments] = useState([]);

  useEffect(() => {
    async function loadAppointments () {
      const response = await api.get('appointments', {
        params: { page: 1 }
      });

      setTrigger(false);

      const parsedDate = response.data.map(appointment => ({
        parsedDate: formatRelative(
           new Date(appointment.date.replace(/-/g, "/")),
           new Date(),
            { addSuffix: true, locale: pt })
      }));

      setDate(parsedDate);
      setAppointments(response.data);
    }

    loadAppointments();
  }, [trigger]);

  async function handleDelete(id) {
    await api.delete(`appointments/${id}`);
    setTrigger(true)
  }

  return (
    <Container>
      <ul>
        { appointments.map((appointment, index) => (
          <Appointment key={ appointment.id } past>
            <span>
              <img src={ appointment.provider.avatar.url } alt='profile'/>
              <span>
                <strong>{ appointment.provider.name }</strong>
                <p>{ date[index].parsedDate }</p>
              </span>
                <img src={ remove } alt='delete' onClick={ () => handleDelete(appointment.id) }/>
            </span>
          </Appointment>
        )) }
      </ul>
    </Container>
  );
}

export default ClientDashboard
