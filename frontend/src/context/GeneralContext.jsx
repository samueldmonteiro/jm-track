import { createContext, useContext, useState} from 'react';

const GeneralContext = createContext();

export default function GeneralProvider({ children }) {

  const [newCampaignCreated, setNewCampaignCreated] = useState(false);

  const toggleNewCampaignCreated = (status) => {
    setNewCampaignCreated(status);
    setTimeout(() => {
      setNewCampaignCreated(!status);
    }, 1000);
  }
  return <GeneralContext.Provider value={{ toggleNewCampaignCreated, newCampaignCreated }}>
    {children}
  </GeneralContext.Provider>;
}

export const useGeneralProvider = () => useContext(GeneralContext);