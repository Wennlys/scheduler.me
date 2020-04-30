import styled from 'styled-components'
import { darken } from 'polished'

import background from '~/assets/background.jpg'

export const Wrapper = styled.div`
    height: 100%;
    background: linear-gradient(180deg, rgba(255, 228, 120, 0.9) 0%, rgba(232, 195, 109, 0.9) 100%),
        url(${background});
    background-size: cover;

    padding: 0 115px;
`

export const Content = styled.div`
    pointer-events: ${props => (props.disable ? 'none' : 'all')};

    padding-top: 30px;

    button {
        text-decoration: none;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #8354b3;
        font-size: 24px;
        color: #fff;
        box-shadow: 4px 4px rgba(0, 0, 0, 0.25);
        outline: none;

        :hover {
            background: ${darken(0.05, '#8354B3')};
            cursor: pointer;
        }

        :first-child {
            background: none;
            box-shadow: none;
            color: #000;
            font-size: 24px;
            font-weight: 400;
        }
    }

    nav {
        height: 70px;
        display: flex;
        justify-content: space-between;

        img {
            height: 100%;
        }

        aside {
            display: flex;
            align-items: center;
            font-size: 24px;

            div:hover {
                cursor: pointer;
            }

            button {
                width: 190px;
                height: 65px;
                margin-left: 22px;
                font-weight: bold;
            }
        }
    }

    div.container {
        margin-top: 175px;
        max-height: 100%;
        display: flex;

        img {
            min-width: 60%;
            margin-right: -250px;
        }

        span {
            display: flex;
            flex-direction: column;
            margin-top: 100px;

            strong {
                font-size: 64px;
                margin-bottom: 60px;
                text-align: center;
            }

            button {
                font-size: 48px;
                font-weight: 400;
                width: 415px;
                height: 128px;
                margin-left: 300px;
            }
        }
    }
`
