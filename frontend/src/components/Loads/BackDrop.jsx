import { Backdrop, CircularProgress } from '@mui/material';
import React from 'react'

const BackDrop = ({isOpen}) => {
    return (
        <div>
            <Backdrop
                sx={(theme) => ({ color: '#fff', zIndex: theme.zIndex.drawer + 1 })}
                open={isOpen}
            >
                <CircularProgress color="inherit" />
            </Backdrop>
        </div>
    );
}

export default BackDrop