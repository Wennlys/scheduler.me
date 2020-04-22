import React from 'react'
import { MdChevronLeft, MdChevronRight } from 'react-icons/all'

import { Container, Time } from './styles'

import profile from '~/assets/profile.png'
import remove from '~/assets/delete.svg';

const ClientDashboard = props => {
  return (
    <Container>
      <header>
        <button type='button'>
          <MdChevronLeft size={36} color='#ffffff' />
        </button>
        <strong>15 de março</strong>
        <button type='button'>
          <MdChevronRight size={36} color='#ffffff' />
        </button>
      </header>

      <ul>
        <Time past>
          <span>
            <img src={profile} alt='profile' />
            <span>
              <strong>Wennlys Oliveira</strong>
              <text>quarta-feira às 16:30</text>
            </span>
              <img src={remove} alt='delete' onClick={props.handleDelete} />
          </span>
        </Time>

        <Time>
          <span>
            <img src={profile} alt='profile' />
            <span>
              <strong>Wennlys Oliveira</strong>
              <text>quarta-feira às 16:30</text>
            </span>
            <img src={remove} alt='delete' onClick={props.handleDelete} />
          </span>
        </Time>

      </ul>
    </Container>
  )
}

export default ClientDashboard
