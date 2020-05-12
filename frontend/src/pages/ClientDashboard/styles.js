import styled from 'styled-components'
import { darken } from 'polished';

export const Container = styled.div`
  max-width: 700px;
  margin: 50px auto;

  display: flex;
  flex-direction: column;
  align-items: center;
  
  ul {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 15px;
    margin-top: 30px;
  }
  
`

export const Appointment = styled.li`
  padding: 30px;
  border-radius: 4px;
  background: #fff; 
  opacity: ${props => (props.past ? 0.5 : 1)};
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  text-align: center;
  box-sizing: border-box;
  
  span:first-of-type {
    display: flex;
    align-items: center;
    
    img:first-of-type {
      width: 50px;
      height: 50px;
      border-radius: 50%;
    }
    
    img:last-of-type {
      width: 30px;
      height: 30px;
      cursor: pointer;
    }
    
    strong {
      display: block;
      color: #000;
      font-size: 15px;
      font-weight: 500;
    }
    
    span {
      display: flex;
      flex-direction: column;
      margin: 0 10px;
    }
  }
  
  button {
    padding: 15px;
    width: 300px;
    box-sizing: border-box;
    background: #8354b3;
    color: #fff;
    border: 0;
    border-radius: 4px;
    font-size: 16px;
    transition: background 0.2s;

    a {
        color: #fff;
    }

    &:hover {
        background: ${darken(0.05, '#8354B3')};
    }
  }
`
