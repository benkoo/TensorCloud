package com.vlotar.demo.service;

import com.google.common.collect.Lists;
import com.vlotar.demo.dao.PiwikLogVisitDAO;

import com.vlotar.demo.domain.PiwikLogVisit;
import com.vlotar.demo.domain.User;
import com.vlotar.demo.exception.ResourceNotFoundException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import javax.swing.plaf.synth.SynthDesktopIconUI;
import java.util.Collection;

@Service
public class PiwikLogVisitService {

    @Autowired
    private PiwikLogVisitDAO piwikLogVisitDAO;

    /**
     * Allows to retrieve all existing users from the database.
     * Pagination is not implemented in order to keep it simple.
     *
     * @return the all existing {@link PiwikLogVisit} entities
     */
    public Collection<PiwikLogVisit> getAllPiwikLogVisits() {
        System.out.println(this.piwikLogVisitDAO.findAll());
        return Lists.newArrayList(this.piwikLogVisitDAO.findAll());
    }

    /**
     * Allows to get a user by the given user identifier.
     *
     * @param piwikLogVisitId the piwikLogVisit id
     * @return the {@link PiwikLogVisit}
     */
    public PiwikLogVisit getPiwikLogVisit(final Long piwikLogVisitId) {
        return findPiwikLogVisitOrThrowNotFoundException(piwikLogVisitId);
    }

    private PiwikLogVisit findPiwikLogVisitOrThrowNotFoundException(final Long piwikLogVisitId) {
        PiwikLogVisit piwikLogVisit = this.piwikLogVisitDAO.findOne(piwikLogVisitId);
        if (piwikLogVisit == null) {
            throw new ResourceNotFoundException(String.format("PiwikLogVisit %s not found", piwikLogVisit));
        }
        return piwikLogVisit;
    }
}
