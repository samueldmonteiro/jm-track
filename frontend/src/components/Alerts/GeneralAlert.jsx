import { Alert } from '@mui/material'
import React from 'react'

const GeneralAlert = ({ message, type = 'success' }) => {
  return (
    <Alert
      variant="outlined"
      severity={type}
      sx={{
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        textAlign: 'center',
      }}
    >
      <div>{message}</div>
    </Alert>
  )
}

export default GeneralAlert
