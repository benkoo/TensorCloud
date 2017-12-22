package com.vlotar.demo.service;

import com.google.common.collect.Lists;
import com.vlotar.demo.dao.PiwikLogVisitDAO;

import com.vlotar.demo.domain.PiwikLogVisit;
import com.vlotar.demo.domain.User;
import com.vlotar.demo.exception.ResourceNotFoundException;
import org.omg.CORBA.OBJ_ADAPTER;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.support.rowset.SqlRowSet;
import org.springframework.stereotype.Service;

import javax.swing.plaf.synth.SynthDesktopIconUI;
import java.sql.Blob;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;

@Service
public class PiwikLogVisitService {

    @Autowired
    private PiwikLogVisitDAO piwikLogVisitDAO;


    @Autowired
    private JdbcTemplate jdbcTemplate;

    public String getAllPiwikLogVisitsRaw() throws SQLException {
        //@see:https://piwik.org/faq/how-to/#faq_158
        String sql = "select idsite,idvisit,visit_last_action_time,user_id,inet_ntoa(conv(hex(location_ip), 16, 10)) as location_ip, conv(hex(idvisitor), 16, 10) as idvisitor from piwik_log_visit";
        SqlRowSet rows = jdbcTemplate.queryForRowSet(sql);
//        while (rows.next()) {
//            //
//        }

        List<Object> list = new ArrayList<Object>();
        SqlRowSet rset;

        int colCount = rows.getMetaData().getColumnCount();
        if (rows.next()) {
            for (int i = 1; i <= colCount; i++) {
                list.add(rows.getObject(i));
            }
        }
        return list.toString();
    }

    /**
     * Allows to retrieve all existing users from the database.
     * Pagination is not implemented in order to keep it simple.
     *
     * @return the all existing {@link PiwikLogVisit} entities
     */
    public Collection<PiwikLogVisit> getAllPiwikLogVisits() {
        System.out.println("system.out.println:"+this.piwikLogVisitDAO.findAll());
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
