import styled from "styled-components";


export const Content = styled.div`
  position: absolute;
  margin-top: 15px;
  
  .date-picker-container {
    margin-bottom: 30px;
    margin-left: 120px;
    
    .date-picker {
      cursor: pointer;
      padding: 10px;
      text-align: center;
      font-size: 15px;
      border: 0;
    }
  }
  
  ul {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 15px;
  }
`

export const Time = styled.li`
  width: 230px;
  height: 60px;
  padding: 20px;
  border-radius: 4px;
  background: #fff; 
  text-align: center;
  
  opacity: ${props => props.past ? 1 : 0.5};
  cursor: ${props => props.past ? 'pointer' : 'default'};
`
